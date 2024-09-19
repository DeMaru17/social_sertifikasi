<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Posts::all();
        return view('posts',compact('user','posts'));
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
        // $request->validate([
        //     'content' => 'required|string|max:250',
        //     'hashtag' => 'nullable|string',
        //     'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        // ]);

        $post = new Posts();
        $post->id_user = Auth::user()->id;
        $post->content = $request->input('content');
        $post->hashtag = $request->input('hashtag');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('image','public');
            $name = basename($path);
            $post->image = $name;
        }

        $post->save();

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
        //
    }
}
