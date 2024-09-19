<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     *
     * @return \Illuminate\View\View
     *
     * 1. Fungsi ini hanya akan menampilkan halaman login.
     * 2. Mengarahkan user ke view 'login' untuk memasukkan email dan password.
     */
    public function index()
    {
        return view('login'); // Menampilkan form login
    }

    /**
     * Menangani proses autentikasi login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Melakukan validasi input user untuk email dan password.
     *    - Email harus dalam format yang benar.
     *    - Password harus minimal 8 karakter.
     * 2. Mengambil email dan password yang dimasukkan user dan mencoba autentikasi menggunakan `Auth::attempt()`.
     * 3. Jika autentikasi berhasil, user akan diarahkan ke halaman `posts`.
     * 4. Jika autentikasi gagal, user akan diarahkan kembali ke halaman login dengan pesan error.
     */
    public function actionLogin(Request $request)
    {
        // Validasi input email dan password
        $request->validate([
            'email' => 'required|email', // Email harus ada dan valid
            'password' => 'required|min:8', // Password minimal 8 karakter
        ]);

        // Mengambil email dan password dari request
        $credential = $request->only(['email', 'password']);

        // Cek apakah email dan password cocok menggunakan Auth::attempt()
        if (Auth::attempt($credential)) {
            // Jika login berhasil, arahkan ke halaman posts
            return redirect()->intended('posts');
        } else {
            // Jika login gagal, beri notifikasi error
            $error = 'Login gagal. Mohon periksa kembali email dan password anda!';
            return redirect()->back()->withErrors(['login' => $error]);
        }
    }

    /**
     * Menangani proses logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Menggunakan `Auth::logout()` untuk mengeluarkan user yang sedang login.
     * 2. Setelah logout, user akan diarahkan ke halaman login.
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user dari sesi yang aktif
        return redirect()->route('login'); // Arahkan ke halaman login
    }
}
