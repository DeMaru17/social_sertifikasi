@extends('layouts.app')

@section('title', 'Timeline')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <!-- Timeline Content -->
            <div class="col-md-8">
                @foreach($posts as $post)
                    <div class="col-md-8 mx-auto mt-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header d-flex align-items-center">
                                <img src="{{ asset('storage/image/' . $post->user->profile_picture) }}" alt="User Avatar" class="img-fluid rounded-circle" style="width: 40px; height: 40px; margin-right: 15px;">
                                <h5 class="mb-0">{{ $post->user->name }}</h5>
                            </div>
                            <div class="card-body">
                                @if($post->image)
                                    <img src="{{ asset('storage/image/' . $post->image) }}" alt="Post Image" class="img-fluid rounded mb-3">
                                @endif
                                <p class="card-text">{{ $post->content }}</p>
                                <a href="{{ route('comments.show', $post->id) }}" class="btn btn-outline-primary btn-sm">Comment</a>
                            </div>
                            <div class="card-footer">
                                <h6>Komentar</h6>
                                @foreach($post->comments as $comment)
                                    <div class="comment mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ asset('storage/image/' . $comment->user->profile_picture) }}" alt="User Avatar" class="img-fluid rounded-circle" style="width: 30px; height: 30px; margin-right: 10px;">
                                            <strong>{{ $comment->user->name }}</strong>
                                        </div>
                                        <p class="mb-1">{{ $comment->content }}</p>
                                        @if($comment->image)
                                            <img src="{{ asset('storage/image/' . $comment->image) }}" alt="Comment Image" class="img-fluid rounded mb-2">
                                        @endif
                                        @if(Auth::user()->id == $comment->id_user)
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="{{ route('comments.edit', $comment->id) }}">Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="{{ route('comments.destroy', $comment->id) }}" data-confirm-delete="true">Delete</a></li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
