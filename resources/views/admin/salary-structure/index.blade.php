@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Salary Structures</h4>
                <a href="{{ route('admin.salary-structures.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Salary Structure
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee</th>
                                        <th>Basic</th>
                                        <th>HRA</th>
                                        <th>Gross Salary</th>
                                        <th>Net Salary</th>
                                        <th>Effective From</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($salaryStructures as $key => $salary)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $salary->employee_name }}</td>
                                            <td>₹{{ number_format($salary->basic, 2) }}</td>
                                            <td>₹{{ number_format($salary->house_rent_allowance, 2) }}</td>
                                            <td>₹{{ number_format($salary->gross_salary, 2) }}</td>
                                            <td>₹{{ number_format($salary->net_salary, 2) }}</td>
                                            <td>{{ $salary->effective_from->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.salary-structures.edit', $salary) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_salary_{{ $salary->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal per row -->
                                        <div id="delete_salary_{{ $salary->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to delete this Salary Structure?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.salary-structures.destroy', $salary) }}" method="POST" style="display:inline;">
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
                                            <td colspan="8" class="text-center">No salary structures found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection