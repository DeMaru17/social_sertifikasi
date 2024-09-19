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
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Posts::with('comments')->orderBy('id', 'desc')->get();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('posts', compact('user', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_posts');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $post = new Posts();
        $post->id_user = Auth::user()->id;
        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('image', 'public');
            $name = basename($path);
            $post->image = $name;
        }

        $post->save();

        Alert::success('Success', 'Berhasil mengupload postingan');

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Posts::findOrFail($id);
        return view('edit_post', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posts $post)
    {

        // Update data
        $post->update([
            'content' => $request->content,
        ]);

        // Jika ada gambar yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar sebelumnya
            Storage::delete('public/image/' . $post->image);

            $image = $request->file('image');
            $path = $image->store('image', 'public');
            $name = basename($path);
            // Update gambar
            $post->update([
                'image' => $name,
            ]);
        }
        Alert::success('Success', 'Berhasil mengupdate postingan');
        // Redirect ke halaman post
        return redirect()->route('posts.index')->with('success', 'Post berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Posts::findOrFail($id);
        if ($post) {
            // Hapus gambar jika ada
            if ($post->image) {
                Storage::delete('public/image/' . $post->image);
            }

            // Hapus data post
            $post->delete();
            Alert::success('Success', 'Berhasil menghapus postingan');
            return redirect()->route('user.index')->with('success', 'Post berhasil dihapus');
        } else {
            Alert::error('Error', 'Postingan tidak ditemukan');
            return redirect()->route('user.index')->with('error', 'Post tidak ditemukan');
        }
    }
}
