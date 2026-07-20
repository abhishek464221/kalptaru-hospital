@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="page-title">Salary Structures</h4>
                    <a href="{{ route('admin.salary-structures.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Structure
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Type</th>
                                        <th>Base Salary</th>
                                        <th>Frequency</th>
                                        <th>Allowances</th>
                                        <th>Deductions</th>
                                        <th>Status</th>
                                        <th>Effective From</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($structures as $key => $structure)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <strong>{{ $structure->employee->full_name ?? 'N/A' }}</strong>
                                                <br>
                                                <small>{{ $structure->employee->employee_id ?? $structure->employee->doctor_id ?? 'N/A' }}</small>
                                            </td>
                                            <td>{{ class_basename($structure->employee_type) }}</td>
                                            <td>₹{{ number_format($structure->base_salary, 2) }}</td>
                                            <td>{{ ucfirst($structure->payment_frequency) }}</td>
                                            <td>
                                                @php
                                                    $allowances = $structure->allowances ? array_sum($structure->allowances) : 0;
                                                @endphp
                                                ₹{{ number_format($allowances, 2) }}
                                            </td>
                                            <td>
                                                @php
                                                    $deductions = $structure->deductions ? array_sum($structure->deductions) : 0;
                                                @endphp
                                                ₹{{ number_format($deductions, 2) }}
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $structure->is_active ? 'success' : 'secondary' }}">
                                                    {{ $structure->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $structure->effective_from->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.salary-structures.show', $structure) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.salary-structures.edit', $structure) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_structure_{{ $structure->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal -->
                                        <div id="delete_structure_{{ $structure->id }}" class="modal fade delete-modal">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <h3>Are you sure want to delete this Salary Structure?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.salary-structures.destroy', $structure) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No salary structures found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $structures->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection