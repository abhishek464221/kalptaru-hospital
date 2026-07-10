@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Doctor</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Doctor ID <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="doctor_id" value="{{ old('doctor_id') }}" required>
                                @error('doctor_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Specialization <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="specialization" value="{{ old('specialization') }}" required>
                                @error('specialization')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Consultation Fee</label>
                                <input class="form-control" type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Experience (Years)</label>
                                <input class="form-control" type="number" name="experience_years" value="{{ old('experience_years', 0) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input class="form-control" type="file" name="image">
                        @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Available Days</label>
                        <div class="row">
                            @php $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday']; @endphp
                            @foreach($days as $day)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="available_days[]" value="{{ $day }}" id="day_{{ $day }}"
                                            {{ in_array($day, old('available_days', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="day_{{ $day }}">{{ ucfirst($day) }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('available_days')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Opening Time</label>
                                <input class="form-control" type="time" name="opening_time" value="{{ old('opening_time') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Closing Time</label>
                                <input class="form-control" type="time" name="closing_time" value="{{ old('closing_time') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Qualification</label>
                        <textarea class="form-control" name="qualification" rows="3">{{ old('qualification') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_active" id="doctor_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="doctor_active">Active</label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection