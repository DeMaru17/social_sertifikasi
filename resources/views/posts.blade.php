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
                            <p>{{ $post->hashtag }}</p>

                            <a href="{{route('comments.show',$post->id)}}">Comment</a>
                            <hr>
                            <h5>Komentar</h5>

                            @foreach($post->comments as $comment)
                            <strong>{{ $comment->user->name }}</strong>
                            <p>{{ $comment->content }}</p>
                            <p>{{$comment->hashtag}}</p>
                            <img src="{{ asset('storage/image/' . $comment->image) }}" alt="" class="img-fluid">
                            @if(Auth::user()->id == $comment->id_user)
                            <a href="{{route('comments.edit', $comment->id)}}" class="btn btn-sm btn-primary mt-3">Edit</a>
                            <a href="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger btn-sm mt-3" data-confirm-delete="true">Delete</a>
                            @endif
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
