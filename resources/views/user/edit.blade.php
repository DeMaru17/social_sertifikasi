@extends('layouts.app')
@section('title','Edit User')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
    <div class="row">
        <div class="col-md-12">
            <div class="card mx-auto" style="width: 80%; max-width: 800px;">
                <div class="card-header">Edit User</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}"  >


                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control " name="email" value="{{ $user->email }}"  >


                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control " name="new_password"  >


                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="old_password" >
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="profile_picture" class="col-md-4 col-form-label text-md-right">Profile Picture</label>

                            <div class="col-md-6">
                                <input id="profile_picture" type="file"   name="profile_picture">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="bio" class="col-md-4 col-form-label text-md-right">Bio</label>

                            <div class="col-md-6">
                                <textarea id="bio" class="form-control " name="bio" required>{{ $user->bio }}</textarea>


                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
