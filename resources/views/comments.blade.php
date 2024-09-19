@extends('layouts.app')
@section('title', 'Create Comment')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-4">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Create Comment</strong>
                </div>
                <div class="card-body">
                        <strong>{{ $post->user->name }}</strong>
                    <div class="card-body">
                        @if($post->image)
                            <img src="{{ asset('storage/image/' . $post->image) }}" alt="Post Image" class="img-fluid">
                        @endif
                        <div class="mt-3">{{ $post->content }}</div>
                        <p>{{ $post->hashtag }}</p>
                    </div>
                    <form method="POST" action="{{ route('comments.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea class="form-control" id="content" name="content" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="hashtag">Hashtag</label>
                            <input type="text" name="hashtag" id="hashtag" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <input type="hidden" name="id_post" value="{{ $post->id }}">
                        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                        <button type="submit" class="btn btn-primary mt-3">Create Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
