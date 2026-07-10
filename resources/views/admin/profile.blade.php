@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-7 col-6">
                <h4 class="page-title">My Profile</h4>
            </div>
            <div class="col-sm-5 col-6 text-right m-b-30">
                <a href="{{ route('admin.edit-profile') }}" class="btn btn-primary btn-rounded">
                    <i class="fa fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
        <div class="card-box profile-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#">
                                    <img class="avatar" src="{{ $user->image ? asset('uploads/users/'.$user->image) : asset('assets/img/user.jpg') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{ $user->name }}</h3>
                                        <small class="text-muted">{{ $user->role->name ?? 'Administrator' }}</small>
                                        <div class="staff-id">User ID : {{ $user->id }}</div>
                                        <div class="staff-msg">
                                            <a href="{{ route('admin.chats.index') }}" class="btn btn-primary">
                                                <i class="fa fa-comments"></i> Go to Chat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <span class="title">Email:</span>
                                            <span class="text"><a href="#">{{ $user->email }}</a></span>
                                        </li>
                                        <li>
                                            <span class="title">Role:</span>
                                            <span class="text">{{ $user->role->name ?? 'N/A' }}</span>
                                        </li>
                                        <li>
                                            <span class="title">Joined:</span>
                                            <span class="text">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection