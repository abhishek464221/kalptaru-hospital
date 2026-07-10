@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Notification</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.notification.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control" name="user_id">
                            <option value="">Select User (Optional)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="title" value="{{ old('title') }}" required>
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="message" rows="4" required>{{ old('message') }}</textarea>
                        @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" name="type">
                                    <option value="">Select Type</option>
                                    <option value="email" {{ old('type') == 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="sms" {{ old('type') == 'sms' ? 'selected' : '' }}>SMS</option>
                                    <option value="push" {{ old('type') == 'push' ? 'selected' : '' }}>Push</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Target Audience</label>
                                <input class="form-control" type="text" name="target_audience" value="{{ old('target_audience') }}" placeholder="e.g. admin, doctor, all">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sent Date</label>
                                <input class="form-control" type="datetime-local" name="sent_at" value="{{ old('sent_at') }}">
                                @error('sent_at')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="display-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="is_read" id="is_read" value="1" {{ old('is_read') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_read">Mark as Read</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Notification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection