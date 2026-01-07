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
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Ambil data yang sudah divalidasi dari ProfileUpdateRequest
        // Ini mencakup name, email, phone, address, dan avatar
        $validatedData = $request->validated();

        // 2. Isi data teks ke dalam model (name, email, phone, address)
        // fill() hanya akan mengisi field yang terdaftar di $fillable pada Model User
        $user->fill($validatedData);

        // 3. Cek jika email berubah, maka reset verifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 4. Handle Upload Avatar secara manual
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada untuk menghemat penyimpanan
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan file baru dengan nama unik
            $filename = 'avatar-' . $user->id . '-' . time() . '.' . $request->file('avatar')->extension();
            $path = $request->file('avatar')->storeAs('avatars', $filename, 'public');

            // Set path ke properti avatar (ini yang memastikan DB tidak NULL)
            $user->avatar = $path;
        }

        // 5. Simpan perubahan ke Database
        $user->save();

        return Redirect::route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menghapus avatar (kembali ke inisial).
     */
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            
            // Update kolom avatar menjadi NULL di database
            $user->avatar = null;
            $user->save();
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
     * Menghapus akun user permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}