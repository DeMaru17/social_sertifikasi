@extends('layouts.app')
@section('title','Update Post')
@section('content')

<div class="card">
    <div class="card-header">Update Post</div>
    <div class="card-body">
        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="content">Caption</label>
                <textarea name="content" id="content" class="form-control" required>{{ $post->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
                <img src="{{ asset('storage/image/' . $post->image) }}" alt="Gambar" width="100px">
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
</div>

@endsection
