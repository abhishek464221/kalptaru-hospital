@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Doctors</h4>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add Doctor</a>
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
                                        <th>Image</th>
                                        <th>Doctor ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Specialization</th>
                                        <th>Fee</th>
                                        <th>Experience</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($doctors as $key => $doctor)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td><img src="{{ $doctor->image }}" alt="{{ $doctor->full_name }}" style="width:50px; height:50px; object-fit:cover; border-radius:50%;"></td>
                                            <td>{{ $doctor->doctor_id }}</td>
                                            <td>{{ $doctor->full_name }}</td>
                                            <td>{{ $doctor->email }}</td>
                                            <td>{{ $doctor->specialization }}</td>
                                            <td>₹{{ number_format($doctor->consultation_fee,2) }}</td>
                                            <td>{{ $doctor->experience_years }} yrs</td>
                                            <td>
                                                @if($doctor->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_doctor_{{ $doctor->id }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Delete Modal -->
                                        <div id="delete_doctor_{{ $doctor->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to delete this Doctor?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" style="display:inline;">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr><td colspan="10" class="text-center">No doctors found.</td></tr>
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