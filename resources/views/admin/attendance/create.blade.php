@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Mark Attendance</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.attendances.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Employee <span class="text-danger">*</span></label>
                        <select class="form-control" name="employee_id" required>
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->full_name }} ({{ $employee->employee_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span></label>
                        <input class="form-control" type="date" name="attendance_date" value="{{ old('attendance_date') }}" required>
                        @error('attendance_date')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Check In</label>
                                <input class="form-control" type="time" name="check_in" value="{{ old('check_in') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Check Out</label>
                                <input class="form-control" type="time" name="check_out" value="{{ old('check_out') }}">
                                @error('check_out')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="status" required>
                            <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="leave" {{ old('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                            <option value="half_day" {{ old('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                            <option value="holiday" {{ old('status') == 'holiday' ? 'selected' : '' }}>Holiday</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Mark Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection