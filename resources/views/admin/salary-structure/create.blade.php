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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="employee_type" id="employee_type" required>
                                    <option value="">Select Type</option>
                                    <option value="doctor" {{ old('employee_type') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                                    <option value="employee" {{ old('employee_type') == 'employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                                @error('employee_type')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee <span class="text-danger">*</span></label>
                                <select class="form-control" name="employee_id" id="employee_id" required>
                                    <option value="">Select Employee</option>
                                </select>
                                @error('employee_id')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Base Salary <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="base_salary" step="0.01" min="0" value="{{ old('base_salary') }}" required>
                                @error('base_salary')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Frequency <span class="text-danger">*</span></label>
                                <select class="form-control" name="payment_frequency" required>
                                    <option value="monthly" {{ old('payment_frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="weekly" {{ old('payment_frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="hourly" {{ old('payment_frequency') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                                </select>
                                @error('payment_frequency')<span class="text-danger">{{ $message }}</span>@enderror
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

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Allowances (JSON)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Travel Allowance</label>
                                        <input class="form-control" type="number" name="allowances[travel]" step="0.01" min="0" value="{{ old('allowances.travel') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Medical Allowance</label>
                                        <input class="form-control" type="number" name="allowances[medical]" step="0.01" min="0" value="{{ old('allowances.medical') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>DA (Dearness Allowance)</label>
                                        <input class="form-control" type="number" name="allowances[da]" step="0.01" min="0" value="{{ old('allowances.da') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Other Allowance</label>
                                        <input class="form-control" type="number" name="allowances[other]" step="0.01" min="0" value="{{ old('allowances.other') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Deductions (JSON)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tax Deduction</label>
                                        <input class="form-control" type="number" name="deductions[tax]" step="0.01" min="0" value="{{ old('deductions.tax') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provident Fund</label>
                                        <input class="form-control" type="number" name="deductions[pf]" step="0.01" min="0" value="{{ old('deductions.pf') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Loan Deduction</label>
                                        <input class="form-control" type="number" name="deductions[loan]" step="0.01" min="0" value="{{ old('deductions.loan') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Other Deduction</label>
                                        <input class="form-control" type="number" name="deductions[other]" step="0.01" min="0" value="{{ old('deductions.other') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Variable Components (JSON)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Per Consultation Fee (for Doctors)</label>
                                        <input class="form-control" type="number" name="variable_components[per_consultation]" step="0.01" min="0" value="{{ old('variable_components.per_consultation') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Bonus Percent</label>
                                        <input class="form-control" type="number" name="variable_components[bonus_percent]" step="0.01" min="0" value="{{ old('variable_components.bonus_percent') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Overtime Rate (per hour)</label>
                                        <input class="form-control" type="number" name="variable_components[overtime_rate]" step="0.01" min="0" value="{{ old('variable_components.overtime_rate') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="display-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Structure</button>
                        <a href="{{ route('admin.salary-structures.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Load employees based on type
        $('#employee_type').on('change', function() {
            let type = $(this).val();
            let $employeeSelect = $('#employee_id');
            $employeeSelect.html('<option value="">Loading...</option>');

            if (type) {
                $.get('/admin/get-employees', { type: type }, function(data) {
                    $employeeSelect.html('<option value="">Select Employee</option>');
                    $.each(data, function(index, employee) {
                        $employeeSelect.append('<option value="' + employee.id + '">' + employee.name + '</option>');
                    });
                });
            } else {
                $employeeSelect.html('<option value="">Select Employee</option>');
            }
        });

        // Trigger change on page load if type is selected
        let initialType = $('#employee_type').val();
        if (initialType) {
            $('#employee_type').trigger('change');
        }
    });
</script>
@endpush