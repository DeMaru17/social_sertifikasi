@extends('layouts.app')
@section('title','User')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto" style="width: 80%; max-width: 800px;">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/image/' . $user->profile_picture) }}" alt="Profile Picture" class="img-fluid rounded-circle">
                        </div>
                        <div class="col-md-8">
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Bio:</strong></p>
                            <p>{{ $user->bio }}</p>
                        </div>
                    </div>
                    <a href="{{route('user.edit', $user->id)}}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <!-- Other elements here -->
        <div class="col-md-12">
            <!-- Card looping here -->
            @foreach($posts as $item)
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
                            <p>Hashtag: {{ $item->hashtag }}</p>

                                <div class="mt-2">
                                    <a href="{{ route('posts.edit', $item->id) }}" class="btn btn-primary">Update</a>
                                    <a href="{{ route('posts.destroy', $item->id) }}" class="btn btn-danger" data-confirm-delete="true">Delete</a>
                                </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection
