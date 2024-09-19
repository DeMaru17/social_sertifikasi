<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PostsController extends Controller
{
    /**
     * Menampilkan daftar postingan.
     *
     * @return \Illuminate\View\View
     *
     * 1. Mengambil informasi user yang sedang login melalui Auth.
     * 2. Mengambil gambar profil user dari database.
     * 3. Mengambil semua postingan dari database beserta komentar yang terkait, diurutkan berdasarkan ID terbaru.
     * 4. Memanggil SweetAlert untuk menampilkan konfirmasi penghapusan.
     * 5. Menampilkan view 'posts' dengan data user dan postingan.
     */
    public function index()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        $profilePicture = $user->profile_picture; // Ambil gambar profil user
        $posts = Posts::with('comments')->orderBy('id', 'desc')->get(); // Ambil semua post dengan komentar terkait, urut berdasarkan ID

        // Konfirmasi penghapusan dengan SweetAlert
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('posts', compact('user', 'posts')); // Tampilkan view 'posts' dengan data user dan postingan
    }

    /**
     * Menampilkan form untuk membuat postingan baru.
     *
     * @return \Illuminate\View\View
     *
     * 1. Mengarahkan user ke halaman form pembuatan postingan.
     */
    public function create()
    {
        return view('create_posts'); // Tampilkan view 'create_posts'
    }

    /**
     * Menyimpan postingan baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Membuat objek baru dari model `Posts`.
     * 2. Mengambil ID user yang sedang login dari Auth.
     * 3. Menyimpan konten dan gambar postingan (jika ada) ke dalam database.
     * 4. Menampilkan notifikasi sukses menggunakan SweetAlert.
     * 5. Redirect ke halaman index postingan dengan pesan sukses.
     */
    public function store(Request $request)
    {
        // Buat objek post baru
        $post = new Posts();
        $post->id_user = Auth::user()->id; // Menyimpan ID user yang login
        $post->content = $request->input('content'); // Simpan konten postingan

        // Jika ada file gambar yang diupload
        if ($request->hasFile('image')) {
            $image = $request->file('image'); // Ambil file gambar
            $path = $image->store('image', 'public'); // Simpan gambar di folder 'public/image'
            $name = basename($path); // Ambil nama file
            $post->image = $name; // Simpan nama file ke database
        }

        $post->save(); // Simpan postingan ke database

        // Menampilkan notifikasi sukses
        Alert::success('Success', 'Berhasil mengupload postingan');

        return redirect()->route('posts.index')->with('success', 'Post created successfully!'); // Redirect dengan pesan sukses
    }

    /**
     * Menampilkan form untuk mengedit postingan.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     *
     * 1. Mengambil data postingan berdasarkan ID.
     * 2. Menampilkan halaman edit dengan data postingan yang diambil.
     */
    public function edit(string $id)
    {
        $post = Posts::findOrFail($id); // Cari postingan berdasarkan ID
        return view('edit_post', compact('post')); // Tampilkan view 'edit_post' dengan data post
    }

    /**
     * Memperbarui postingan di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Posts  $post
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Memperbarui konten postingan di database.
     * 2. Jika ada file gambar baru yang diupload, gambar lama akan dihapus dan gambar baru disimpan.
     * 3. Menampilkan notifikasi sukses menggunakan SweetAlert.
     * 4. Redirect ke halaman index postingan dengan pesan sukses.
     */
    public function update(Request $request, Posts $post)
    {
        // Update konten postingan
        $post->update([
            'content' => $request->content,
        ]);

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::delete('public/image/' . $post->image);

            $image = $request->file('image'); // Ambil file gambar baru
            $path = $image->store('image', 'public'); // Simpan gambar baru di folder 'public/image'
            $name = basename($path); // Ambil nama file baru

            // Update gambar di database
            $post->update([
                'image' => $name,
            ]);
        }

        // Menampilkan notifikasi sukses
        Alert::success('Success', 'Berhasil mengupdate postingan');

        // Redirect dengan pesan sukses
        return redirect()->route('posts.index')->with('success', 'Post berhasil diupdate!');
    }

    /**
     * Menghapus postingan dari database.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Mengambil postingan berdasarkan ID.
     * 2. Jika ada gambar yang terkait dengan postingan, gambar akan dihapus dari penyimpanan.
     * 3. Menghapus postingan dari database.
     * 4. Menampilkan notifikasi sukses atau error dan redirect ke halaman index user.
     */
    public function destroy(string $id)
    {
        $post = Posts::findOrFail($id); // Cari postingan berdasarkan ID
        if ($post) {
            // Hapus gambar terkait jika ada
            if ($post->image) {
                Storage::delete('public/image/' . $post->image); // Hapus gambar dari penyimpanan
            }

            // Hapus postingan dari database
            $post->delete();
            Alert::success('Success', 'Berhasil menghapus postingan'); // Notifikasi sukses
            return redirect()->route('user.index')->with('success', 'Post berhasil dihapus'); // Redirect dengan pesan sukses
        } else {
            // Jika postingan tidak ditemukan
            Alert::error('Error', 'Postingan tidak ditemukan'); // Notifikasi error
            return redirect()->route('user.index')->with('error', 'Post tidak ditemukan');
        }
    }
}
