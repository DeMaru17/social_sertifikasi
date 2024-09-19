@extends('layouts.app')
@section('title','create post')
@section('content')


<div class="d-flex justify-content-center align-items-center mt-4">
<div class="card" style="width:  50rem;">
    <div class="card-header">Create Post</div>
    <div class="card-body">
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="content">Caption</label>
                <textarea name="content" id="content" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary mt-4">Create Post</button>
        </form>
    </div>
</div>
</div>

@endsection
