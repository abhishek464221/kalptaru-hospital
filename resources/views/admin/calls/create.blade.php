@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Add Call Log</h4>
                <a href="{{ route('admin.calls.history') }}" class="btn btn-secondary mb-3">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.calls.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>User</label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Call Type</label>
                                <select name="call_type" class="form-control" required>
                                    <option value="audio">Audio</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Direction</label>
                                <select name="direction" class="form-control" required>
                                    <option value="outgoing">Outgoing</option>
                                    <option value="incoming">Incoming</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Duration (seconds)</label>
                                <input type="number" name="duration_seconds" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Follow Up Required</label>
                                <select name="follow_up_required" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Follow Up Date</label>
                                <input type="date" name="follow_up_date" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Save Call Log</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection