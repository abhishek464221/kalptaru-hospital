@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Leave Request</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.leaves.update', $leave) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Employee <span class="text-danger">*</span></label>
                        <select class="form-control" name="employee_id" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id', $leave->employee_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }} ({{ $employee->employee_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Leave Type <span class="text-danger">*</span></label>
                        <select class="form-control" name="leave_type" required>
                            <option value="casual" {{ old('leave_type', $leave->leave_type) == 'casual' ? 'selected' : '' }}>Casual</option>
                            <option value="sick" {{ old('leave_type', $leave->leave_type) == 'sick' ? 'selected' : '' }}>Sick</option>
                            <option value="earned" {{ old('leave_type', $leave->leave_type) == 'earned' ? 'selected' : '' }}>Earned</option>
                            <option value="maternity" {{ old('leave_type', $leave->leave_type) == 'maternity' ? 'selected' : '' }}>Maternity</option>
                            <option value="paternity" {{ old('leave_type', $leave->leave_type) == 'paternity' ? 'selected' : '' }}>Paternity</option>
                            <option value="other" {{ old('leave_type', $leave->leave_type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('leave_type')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="end_date" value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" required>
                                @error('end_date')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea class="form-control" name="reason" rows="3">{{ old('reason', $leave->reason) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status" required>
                            <option value="pending" {{ old('status', $leave->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $leave->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $leave->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Approved By</label>
                        <select class="form-control" name="approved_by">
                            <option value="">Select Approver</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('approved_by', $leave->approved_by) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('approved_by')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Rejection Reason</label>
                        <textarea class="form-control" name="rejection_reason" rows="2">{{ old('rejection_reason', $leave->rejection_reason) }}</textarea>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Leave Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection