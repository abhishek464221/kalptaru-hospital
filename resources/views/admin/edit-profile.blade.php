@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Edit Profile</h4>
            </div>
        </div>

        <form action="{{ route('admin.update-profile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-box">
                <h3 class="card-title">Basic Informations</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-img-wrap">
                            <img class="inline-block" src="{{ asset('uploads/users/' . ($user->image ?? 'default.png')) }}" alt="user">
                            <div class="fileupload btn">
                                <span class="btn-text">Edit</span>
                                <input class="upload" type="file" name="avatar">
                            </div>
                            @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Full Name</label>
                                        <input type="text" name="name" class="form-control floating" value="{{ old('name', $user->name) }}" required>
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Email</label>
                                        <input type="email" name="email" class="form-control floating" value="{{ old('email', $user->email) }}" required>
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center m-t-20">
                <button class="btn btn-primary submit-btn" type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection