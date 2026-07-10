@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Edit Schedule</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee</label>
                                <select class="form-control" name="employee_id">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('employee_id', $schedule->employee_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }} ({{ $employee->employee_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Doctor</label>
                                <select class="form-control" name="doctor_id">
                                    <option value="">Select Doctor</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $schedule->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->full_name }} ({{ $doctor->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Day of Week <span class="text-danger">*</span></label>
                        <select class="form-control" name="day_of_week" required>
                            <option value="">Select Day</option>
                            @php
                                $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                            @endphp
                            @foreach($days as $day)
                                <option value="{{ $day }}" {{ old('day_of_week', $schedule->day_of_week) == $day ? 'selected' : '' }}>
                                    {{ ucfirst($day) }}
                                </option>
                            @endforeach
                        </select>
                        @error('day_of_week')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="time" name="start_time" value="{{ old('start_time', $schedule->start_time ? $schedule->start_time->format('H:i') : '') }}" required>
                                @error('start_time')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Time <span class="text-danger">*</span></label>
                                <input class="form-control" type="time" name="end_time" value="{{ old('end_time', $schedule->end_time ? $schedule->end_time->format('H:i') : '') }}" required>
                                @error('end_time')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Working Day</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_working_day" id="is_working_day" value="1" {{ old('is_working_day', $schedule->is_working_day) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_working_day">Is Working Day</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Update Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection