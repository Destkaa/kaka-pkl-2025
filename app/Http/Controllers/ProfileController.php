<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
     * Mengupdate informasi profil user.
     * Mendukung update parsial (hanya foto, atau hanya teks).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Ambil data yang sudah divalidasi
        $data = $request->validated();

        // LOGIKA 1: Jika ada file Avatar yang diunggah
        if ($request->hasFile('avatar')) {
            $user->avatar = $this->uploadAvatar($request, $user);
        }

        // LOGIKA 2: Hanya update field teks jika field tersebut ada di dalam request
        // Ini mencegah data di database menjadi null saat Anda hanya klik "Simpan Foto"
        if ($request->has('name')) {
            $user->name = $data['name'];
        }

        if ($request->has('email')) {
            // Jika email berubah, tandai email_verified_at sebagai null
            if ($user->email !== $data['email']) {
                $user->email = $data['email'];
                $user->email_verified_at = null;
            }
        }

        if ($request->has('phone')) {
            $user->phone = $data['phone'];
        }

        if ($request->has('address')) {
            $user->address = $data['address'];
        }

        // Simpan perubahan
        $user->save();

        return Redirect::route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Helper khusus untuk menangani logika upload avatar.
     */
    protected function uploadAvatar(ProfileUpdateRequest $request, $user): string
    {
        // 1. Hapus avatar lama dari storage jika ada (biar tidak jadi sampah)
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // 2. Generate nama file unik: avatar-id-timestamp.ekstensi
        $filename = 'avatar-' . $user->id . '-' . time() . '.' . $request->file('avatar')->extension();

        // 3. Simpan ke folder 'avatars' di disk 'public'
        // Kembalikan path yang akan disimpan ke database (misal: avatars/xyz.jpg)
        return $request->file('avatar')->storeAs('avatars', $filename, 'public');
    }

    /**
     * Menghapus avatar (tombol "Hapus Foto").
     */
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);

            // Set kolom avatar di database kembali menjadi null
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
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Menghapus akun user secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Bersihkan foto profil dari storage saat akun dihapus
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}