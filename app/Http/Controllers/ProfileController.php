<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;  // Mengimpor View dengan benar

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('user.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Mengisi data pengguna dengan data yang tervalidasi
        $user = $request->user();
        $user->fill($request->validated());

        // Set email_verified_at to null if the email is changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Menyimpan perubahan
        $user->save();

        // Redirect kembali ke halaman profil dengan status "profile-updated"
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Memvalidasi password dengan memastikan itu adalah kata sandi saat ini
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout pengguna
        Auth::logout();

        // Menghapus akun pengguna
        $user->delete();

        // Invalidate the session and regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama setelah penghapusan akun
        return Redirect::to('/')->with('status', 'Akun Anda telah dihapus');
    }
}
