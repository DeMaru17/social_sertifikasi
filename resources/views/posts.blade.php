@extends('layouts.app')
@section('title','Timeline')
@section('content')

<div class="container">
    <div class="row">
        <!-- Other elements here -->
        <div class="col-md-12">
            <!-- Card looping here -->
            @foreach($posts as $post)
                <div class="col-md-4 mx-auto mt-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <strong>{{ $post->user->name }}</strong>
                        </div>
                        <div class="card-body">
                            @if($post->image)
                                <img src="{{ asset('storage/image/' . $post->image) }}" alt="Post Image" class="img-fluid">
                            @endif
                            <div class="mt-3">{{ $post->content }}</div>
                            <p>Hashtag: {{ $post->hashtag }}</p>
                            @if(Auth::id() == $post->id_user)
                                <div class="mt-2">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Update</a>
                                    <a href="{{ route('posts.destroy', $post->id) }}" class="btn btn-danger" data-confirm-delete="true">Delete</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
