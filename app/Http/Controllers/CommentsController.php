<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CommentsController extends Controller
{
    /**
     * Menampilkan halaman daftar resource.
     * Saat ini digunakan untuk menampilkan SweetAlert konfirmasi penghapusan data.
     */
    public function index() {
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        // Fungsi custom untuk konfirmasi penghapusan
        confirmDelete($title, $text);
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     * Saat ini kosong karena belum ada implementasi.
     */
    public function create() {}

    /**
     * Menyimpan resource baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Membuat objek baru dari model `Comments`.
     * 2. Menyimpan data komentar berdasarkan inputan user.
     * 3. Menangani unggahan gambar jika ada, kemudian menyimpannya.
     * 4. Memberikan notifikasi sukses menggunakan SweetAlert.
     * 5. Redirect ke halaman indeks post dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $comments = new Comments();
        $comments->id_user = $request->id_user; // Menyimpan id_user dari request
        $comments->id_post = $request->id_post; // Menyimpan id_post dari request
        $comments->content = $request->input('content'); // Menyimpan isi komentar

        // Cek jika ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image'); // Ambil file gambar
            $path = $image->store('image', 'public'); // Simpan di folder 'public/image'
            $name = basename($path); // Ambil nama file
            $comments->image = $name; // Simpan nama file ke dalam database
        }

        $comments->save(); // Simpan data komentar ke database

        // Menampilkan notifikasi sukses
        Alert::success('Success', 'Berhasil komen postingan');
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Menampilkan detail resource berdasarkan ID yang diberikan.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     *
     * 1. Mengambil data post berdasarkan ID.
     * 2. Menampilkan halaman view 'comments' dengan data post yang diambil.
     */
    public function show(string $id)
    {
        $post = Posts::findOrFail($id); // Cari post berdasarkan ID
        return view('comments', compact('post')); // Tampilkan view dengan data post
    }

    /**
     * Menampilkan form untuk mengedit resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     *
     * 1. Mengambil data komentar berdasarkan ID.
     * 2. Menampilkan halaman view 'edit_comments' dengan data komentar.
     */
    public function edit(string $id)
    {
        $comment = Comments::findOrFail($id); // Cari komentar berdasarkan ID
        return view('edit_comments',compact('comment')); // Tampilkan view untuk edit komentar
    }

    /**
     * Memperbarui resource yang ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Mengambil data komentar berdasarkan ID.
     * 2. Memperbarui isi komentar dengan input baru.
     * 3. Menangani unggahan gambar jika ada, kemudian memperbarui gambar.
     * 4. Menampilkan notifikasi sukses dan redirect ke halaman indeks post.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comments::find($id); // Cari komentar berdasarkan ID
        $comment->content = $request->input('content'); // Update isi komentar

        // Cek jika ada file gambar baru yang diunggah
        if ($request->hasFile('image')) {
            $image = $request->file('image'); // Ambil file gambar baru
            $path = $image->store('image', 'public'); // Simpan gambar di folder 'public/image'
            $name = basename($path); // Ambil nama file
            $comment->image = $name; // Update nama file di database
        }

        $comment->save(); // Simpan perubahan ke database

        // Menampilkan notifikasi sukses
        Alert::success('Success', 'Berhasil edit komen postingan');
        return redirect()->route('posts.index')->with('success', 'Comment updated successfully');
    }

    /**
     * Menghapus resource dari database.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * 1. Mengambil data komentar berdasarkan ID.
     * 2. Jika komentar ditemukan, menghapus gambar terkait (jika ada) dari penyimpanan.
     * 3. Menghapus data komentar dari database.
     * 4. Menampilkan notifikasi sukses atau error dan redirect ke halaman indeks post.
     */
    public function destroy(string $id)
    {
        $comment = Comments::findOrFail($id); // Cari komentar berdasarkan ID
        if ($comment) {
            // Hapus gambar terkait jika ada
            if ($comment->image) {
                Storage::delete('public/image/' . $comment->image); // Hapus gambar dari storage
            }

            // Hapus data komentar dari database
            $comment->delete();
            Alert::success('Success', 'Berhasil menghapus komentar'); // Notifikasi sukses
            return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus');
        } else {
            // Jika komentar tidak ditemukan, tampilkan error
            Alert::error('Error', 'komentar tidak ditemukan'); // Notifikasi error
            return redirect()->route('posts.index')->with('error', 'Post tidak ditemukan');
        }
    }
}
