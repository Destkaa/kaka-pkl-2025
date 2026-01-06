<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Mengupdate informasi profil user (Nama, Email, dan Foto).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Ambil semua data validasi KECUALI 'avatar'
        // Ini penting agar string path tidak tertimpa oleh objek file mentah
        $validatedData = $request->safe()->except(['avatar']);

        // 2. Handle Upload Avatar
        if ($request->hasFile('avatar')) {
            // Gunakan helper uploadAvatar yang ada di bawah
            $avatarPath = $this->uploadAvatar($request, $user);
            $user->avatar = $avatarPath;
        }

        // 3. Update Data Text (Nama, Email, Phone, Address)
        $user->fill($validatedData);

        // 4. Cek Perubahan Email
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 5. Simpan ke Database
        $user->save();

        return Redirect::route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Helper khusus menangani logika upload file avatar.
     */
    protected function uploadAvatar(Request $request, $user): string
    {
        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Buat nama file unik
        $filename = 'avatar-' . $user->id . '-' . time() . '.' . $request->file('avatar')->getClientOriginalExtension();

        // Simpan ke storage/app/public/avatars
        return $request->file('avatar')->storeAs('avatars', $filename, 'public');
    }

    /**
     * Mengupdate HANYA foto profil (Biasanya dipanggil lewat AJAX atau form kecil).
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();
        $avatarPath = $this->uploadAvatar($request, $user);

        $user->update([
            'avatar' => $avatarPath,
        ]);

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Menghapus foto profil (Kembali ke default).
     */
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return back()->with('status', 'password-updated');
    }
    
    /**
     * Menghapus akun user permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        
        // Hapus file fisik avatar sebelum hapus data user
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return Redirect::to('/');
    }
}