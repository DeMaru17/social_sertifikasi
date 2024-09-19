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
     * Display a listing of the resource.
     */
    public function index() {
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comments = new Comments();
        $comments->id_user = $request->id_user;
        $comments->id_post = $request->id_post;
        $comments->content = $request->input('content');
        $comments->hashtag = $request->input('hashtag');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('image', 'public');
            $name = basename($path);
            $comments->image = $name;
        }

        $comments->save();

        Alert::success('Success', 'Berhasil komen postingan');
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Posts::findOrFail($id);
        return view('comments', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comments::findOrFail($id);
        if ($comment) {
            // Hapus gambar jika ada
            if ($comment->image) {
                Storage::delete('public/image/' . $comment->image);
            }

            // Hapus data post
            $comment->delete();
            Alert::success('Success', 'Berhasil menghapus komentar');
            return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus');
        } else {
            Alert::error('Error', 'komentar tidak ditemukan');
            return redirect()->route('posts.index')->with('error', 'Post tidak ditemukan');
        }
    }
}
