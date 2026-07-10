@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Call Log</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.calls.update', $call) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee</label>
                                <select class="form-control" name="employee_id">
                                    <option value="">Select Employee (Optional)</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $call->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }} ({{ $employee->employee_id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Call Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="call_type" required>
                                    <option value="incoming" {{ old('call_type', $call->call_type) == 'incoming' ? 'selected' : '' }}>Incoming</option>
                                    <option value="outgoing" {{ old('call_type', $call->call_type) == 'outgoing' ? 'selected' : '' }}>Outgoing</option>
                                    <option value="missed" {{ old('call_type', $call->call_type) == 'missed' ? 'selected' : '' }}>Missed</option>
                                </select>
                                @error('call_type')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Caller Name</label>
                                <input class="form-control" type="text" name="caller_name" value="{{ old('caller_name', $call->caller_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Caller Phone <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="caller_phone" value="{{ old('caller_phone', $call->caller_phone) }}" required>
                                @error('caller_phone')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Receiver Phone</label>
                                <input class="form-control" type="text" name="receiver_phone" value="{{ old('receiver_phone', $call->receiver_phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Duration (seconds)</label>
                                <input class="form-control" type="number" name="duration_seconds" value="{{ old('duration_seconds', $call->duration_seconds) }}" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Call Date & Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="datetime-local" name="call_datetime" value="{{ old('call_datetime', $call->call_datetime->format('Y-m-d\TH:i')) }}" required>
                                @error('call_datetime')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Follow Up Date</label>
                                <input class="form-control" type="date" name="follow_up_date" value="{{ old('follow_up_date', $call->follow_up_date ? $call->follow_up_date->format('Y-m-d') : '') }}">
                                @error('follow_up_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" rows="3">{{ old('notes', $call->notes) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Follow Up Required</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="follow_up_required" id="follow_up_required" value="1" {{ old('follow_up_required', $call->follow_up_required) ? 'checked' : '' }}>
                            <label class="form-check-label" for="follow_up_required">Yes, follow up required</label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Call Log</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection