<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Menampilkan daftar resource yang terkait dengan pengguna.
     *
     * @return \Illuminate\View\View
     *
     * Fungsi ini mengambil data user yang sedang login beserta postingannya dan menampilkannya di halaman user index.
     */
    public function index()
    {
        // Mendapatkan data user yang sedang login
        $user = Auth::user();

        // Mengambil semua postingan yang dibuat oleh user tersebut
        $posts = Posts::where('id_user', $user->id)->get();

        // Mengirimkan data user dan postingan ke view
        return view('user.index', compact('user', 'posts'));
    }

    /**
     * Menampilkan form untuk mengedit data user yang sudah ada.
     *
     * @param string $id
     * @return \Illuminate\View\View
     *
     * Fungsi ini menampilkan form untuk mengedit informasi user berdasarkan ID yang dipilih.
     */
    public function edit(string $id)
    {
        // Mencari data user berdasarkan ID
        $user = User::findOrFail($id);

        // Mengirimkan data user ke view untuk ditampilkan di form edit
        return view('user.edit', compact('user'));
    }

    /**
     * Mengupdate data user yang sudah ada.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Fungsi ini mengupdate data user yang ada berdasarkan input dari form edit, termasuk nama, email, password, dan gambar profil.
     */
    public function update(Request $request, $id)
    {
        // Mencari user berdasarkan ID
        $user = User::findOrFail($id);

        // Mengupdate nama dan email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Memvalidasi password lama dan baru, jika ada
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                // Jika password lama salah, beri peringatan
                Alert::warning('Password lama salah', 'Silahkan cek kembali password lama anda');
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
            }
        }

        // Mengupload dan mengganti gambar profil jika ada
        if ($request->hasFile('profile_picture')) {
            // Hapus gambar profil lama
            if ($user->profile_picture) {
                Storage::delete('public/image/' . $user->profile_picture);
            }

            // Upload gambar profil baru
            $image = $request->file('profile_picture');
            $path = $image->store('image', 'public');
            $name = basename($path);
            $user->profile_picture = $name;
        }

        // Jika password baru diisi, update password
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Mengupdate bio
        $user->bio = $request->input('bio');

        // Menyimpan perubahan data user
        $user->save();

        // Menampilkan pesan sukses dan redirect ke halaman user index
        Alert::success('Success', 'Data berhasil diperbarui');
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    /**
     * Menghapus user yang ada.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Fungsi ini menghapus user dari database berdasarkan ID yang diberikan. Jika berhasil, pengguna akan dialihkan ke halaman login.
     */
    public function destroy(string $id)
    {
        // Mencari user berdasarkan ID
        $user = User::find($id);

        if ($user) {
            // Menghapus user
            $user->delete();

            // Menampilkan pesan sukses dan redirect ke halaman login
            Alert::success('Success', 'User berhasil dihapus');
            return redirect()->route('login')->with('success', 'Account deleted successfully!');
        } else {
            // Menampilkan pesan error jika user tidak ditemukan
            Alert::error('Error', 'User tidak ditemukan');
            return redirect()->route('user.index')->with('error', 'Account not found!');
        }
    }

    /**
     * Menampilkan profil user yang sedang login.
     *
     * @return \Illuminate\View\View
     *
     * Fungsi ini menampilkan profil user beserta postingan yang mereka buat.
     */
    public function showProfile()
    {
        // Mendapatkan data user yang sedang login
        $user = Auth::user();

        // Mengambil semua postingan yang dibuat oleh user
        $posts = Posts::where('id_user', $user->id)->get();

        // Mengirimkan data user dan postingan ke view user.index
        return view('user.index', compact('user', 'posts'));
    }
}
