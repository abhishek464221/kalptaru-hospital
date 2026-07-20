@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Patient</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.patients.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Patient ID <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="patient_id" value="{{ old('patient_id') }}" required>
                                @error('patient_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
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
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" value="{{ old('email') }}">
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input class="form-control" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Emergency Contact</label>
                                <input class="form-control" type="text" name="emergency_contact" value="{{ old('emergency_contact') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Patient Type</label>
                        <select class="form-control" name="patient_type">
                            <option value="">Select Type</option>
                            <option value="OPD" {{ old('patient_type') == 'OPD' ? 'selected' : '' }}>OPD</option>
                            <option value="IPD" {{ old('patient_type') == 'IPD' ? 'selected' : '' }}>IPD</option>
                            <option value="ICU" {{ old('patient_type') == 'ICU' ? 'selected' : '' }}>ICU</option>
                        </select>
                        @error('patient_type')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Medical History</label>
                        <textarea class="form-control" name="medical_history" rows="3">{{ old('medical_history') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_active" id="patient_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="patient_active">Active</label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection