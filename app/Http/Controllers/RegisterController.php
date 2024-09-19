<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi.
     *
     * @return \Illuminate\View\View
     *
     * 1. Mengarahkan user ke halaman form registrasi.
     */
    public function index()
    {
        return view('register'); // Tampilkan view 'register' yang berisi form registrasi
    }

    /**
     * Menyimpan data registrasi user baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Melakukan validasi terhadap input yang diberikan user, seperti nama, email, dan password.
     * 2. Membuat user baru di database dengan data yang sudah divalidasi.
     * 3. Mengenkripsi password menggunakan `Hash` sebelum menyimpannya.
     * 4. Menampilkan notifikasi sukses menggunakan SweetAlert.
     * 5. Mengarahkan user ke halaman login dengan pesan sukses setelah registrasi berhasil.
     */
    public function store(Request $request)
    {
        // Validasi input yang diberikan user
        $request->validate([
            'name' => 'required', // Nama wajib diisi
            'email' => 'required|email', // Email wajib diisi dan harus dalam format email
            'password' => 'required|min:8', // Password wajib diisi dan minimal 8 karakter
        ]);

        // Membuat user baru di database
        User::create([
            'name' => $request->name, // Simpan nama user
            'email' => $request->email, // Simpan email user
            'password' => Hash::make($request->password), // Simpan password yang sudah di-hash (dienkripsi)
        ]);

        // Menampilkan notifikasi sukses setelah user berhasil terdaftar
        Alert::success('Success', 'Akun Telah dibuat');

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }
}
