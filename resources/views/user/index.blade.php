@extends('layouts.app')

@section('title', 'User')

@section('content')
    <div class="container d-flex justify-content-center align-items-center mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card mx-auto" style="width: 80%; max-width: 800px;">
                    <div class="card-header">{{ $user->name }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('storage/image/' . $user->profile_picture) }}" alt="Profile Picture" class="img-fluid rounded-circle">
                            </div>
                            <div class="col-md-8">
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Bio:</strong> {{ $user->bio }}</p>
                            </div>
                        </div>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h2 align="center">Posts</h2>
            @foreach($posts as $item)
            <div class="row">
                    <div class="col-md-4 mx-auto mt-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <strong>{{ $item->user->name }}</strong>
                            </div>
                            <div class="card-body">
                                @if($item->image)
                                    <img src="{{ asset('storage/image/' . $item->image) }}" alt="Post Image" class="img-fluid">
                                @endif
                                <div class="mt-3">{{ $item->content }}</div>
                                <div class="mt-2 d-flex ">
                                    <a href="{{ route('posts.edit', $item->id) }}" class="btn btn-primary">Update</a>
                                    <form action="{{ route('posts.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-3" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
@endsection
