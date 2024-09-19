@extends('layouts.app')
@section('title','Timeline')
@section('content')

<div class="container">
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4 mx-auto mt-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>{{ $post->user->name }}</strong>
                    </div>
                    <div class="card-body">
                        <p>{{ $post->content }}</p>
                        @if($post->image)
                            <img src="{{ asset('storage/image' . $post->image) }}" alt="Post Image" class="img-fluid">
                        @endif
                        <p>Hashtag: {{ $post->hashtag }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
