@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Salary Structure</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.salary-structures.store') }}" method="POST">
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Basic Salary</label>
                                <input class="form-control" type="number" step="0.01" name="basic" value="{{ old('basic', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>House Rent Allowance (HRA)</label>
                                <input class="form-control" type="number" step="0.01" name="house_rent_allowance" value="{{ old('house_rent_allowance', 0) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Conveyance Allowance</label>
                                <input class="form-control" type="number" step="0.01" name="conveyance_allowance" value="{{ old('conveyance_allowance', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Medical Allowance</label>
                                <input class="form-control" type="number" step="0.01" name="medical_allowance" value="{{ old('medical_allowance', 0) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Other Allowances</label>
                                <input class="form-control" type="number" step="0.01" name="other_allowances" value="{{ old('other_allowances', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Provident Fund</label>
                                <input class="form-control" type="number" step="0.01" name="provident_fund" value="{{ old('provident_fund', 0) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tax Deduction</label>
                                <input class="form-control" type="number" step="0.01" name="tax_deduction" value="{{ old('tax_deduction', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Other Deductions</label>
                                <input class="form-control" type="number" step="0.01" name="other_deductions" value="{{ old('other_deductions', 0) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Effective From <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="effective_from" value="{{ old('effective_from') }}" required>
                                @error('effective_from')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Effective To</label>
                                <input class="form-control" type="date" name="effective_to" value="{{ old('effective_to') }}">
                                @error('effective_to')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Salary Structure</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection