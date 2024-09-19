@extends('layouts.app')
@section('title', 'Edit Comment')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-4">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Edit Comment</strong>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.update', $comment->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea class="form-control" id="content" name="content" required>{{ $comment->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="hashtag">Hashtag</label>
                            <input type="text" name="hashtag" id="hashtag" class="form-control" value="{{ $comment->hashtag }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            @if($comment->image)
                                <img src="{{ asset('storage/image/' . $comment->image) }}" alt="Comment Image" class="img-fluid mb-2">
                            @endif
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                       
                        <button type="submit" class="btn btn-primary mt-3">Update Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
