@extends('layouts.app')
@section('title','Hasil Pencarian Hashtag')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Hasil Pencarian untuk: {{ $hashtag }}</h1>

            @if($posts->isEmpty() && $comments->isEmpty())
                <p>Tidak ada hasil yang ditemukan.</p>
            @else
                <!-- Menampilkan Postingan yang Mengandung Hashtag -->
                <h2>Postingan</h2>
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-4 mx-auto mt-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3>{{ $post->user->name }}</h3>
                                </div>
                                <div class="card-body">
                                    @if($post->image)
                                        <img src="{{ asset('storage/image/' . $post->image) }}" alt="Post Image" class="img-fluid">
                                    @endif
                                    <div class="mt-3">{{ $post->content }}</div>
                                    <p>{{ $post->hashtag }}</p>

                                    <a href="{{route('comments.show',$post->id)}}">Comment</a>
                                    <hr>
                                    <h5>Komentar</h5>

                                    @foreach($post->comments as $comment)
                                        <strong>{{ $comment->user->name }}</strong>
                                        <p>{{ $comment->content }}</p>
                                        <p>{{ $comment->hashtag }}</p>
                                        @if($comment->image)
                                            <img src="{{ asset('storage/image/' . $comment->image) }}" alt="Comment Image" class="img-fluid">
                                        @endif
                                        @if(Auth::user()->id == $comment->user_id)
                                            <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-primary mt-3">Edit</a>
                                            <a href="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger btn-sm mt-3" data-confirm-delete="true">Delete</a>
                                        @endif
                                        <hr>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Menampilkan Komentar yang Mengandung Hashtag -->
                <h2>Komentar</h2>
                <div class="row">
                    @foreach($comments as $comment)
                        <div class="col-md-4 mx-auto mt-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>{{ $comment->user->name }}</strong>
                                </div>
                                <div class="card-body">
                                    <p>{{ $comment->content }}</p>
                                    <p>{{ $comment->hashtag }}</p>
                                    @if($comment->image)
                                        <img src="{{ asset('storage/image/' . $comment->image) }}" alt="Comment Image" class="img-fluid">
                                    @endif
                                    @if(Auth::user()->id == $comment->user_id)
                                        <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-primary mt-3">Edit</a>
                                        <a href="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger btn-sm mt-3" data-confirm-delete="true">Delete</a>
                                    @endif
                                    <hr>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
