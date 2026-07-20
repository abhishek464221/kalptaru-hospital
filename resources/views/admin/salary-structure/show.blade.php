@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Salary Structure Details</h4>
                        <div class="float-right">
                            <span class="badge badge-{{ $salaryStructure->is_active ? 'success' : 'secondary' }}">
                                {{ $salaryStructure->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Employee:</strong> {{ $salaryStructure->employee->full_name ?? 'N/A' }}</p>
                                <p><strong>Employee Type:</strong> {{ class_basename($salaryStructure->employee_type) }}</p>
                                <p><strong>Base Salary:</strong> ₹{{ number_format($salaryStructure->base_salary, 2) }}</p>
                                <p><strong>Payment Frequency:</strong> {{ ucfirst($salaryStructure->payment_frequency) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Effective From:</strong> {{ $salaryStructure->effective_from->format('d M Y') }}</p>
                                <p><strong>Effective To:</strong> {{ $salaryStructure->effective_to ? $salaryStructure->effective_to->format('d M Y') : 'N/A' }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Allowances</h5>
                                @if($salaryStructure->allowances)
                                    <ul>
                                        @foreach($salaryStructure->allowances as $key => $value)
                                            <li>{{ ucwords(str_replace('_', ' ', $key)) }}: ₹{{ number_format($value, 2) }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No allowances</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5>Deductions</h5>
                                @if($salaryStructure->deductions)
                                    <ul>
                                        @foreach($salaryStructure->deductions as $key => $value)
                                            <li>{{ ucwords(str_replace('_', ' ', $key)) }}: ₹{{ number_format($value, 2) }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No deductions</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3">
                            <h5>Variable Components</h5>
                            @if($salaryStructure->variable_components)
                                <ul>
                                    @foreach($salaryStructure->variable_components as $key => $value)
                                        <li>{{ ucwords(str_replace('_', ' ', $key)) }}: ₹{{ number_format($value, 2) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No variable components</p>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.salary-structures.edit', $salaryStructure) }}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.salary-structures.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection