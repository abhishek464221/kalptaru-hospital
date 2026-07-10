@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Appointments</h4>
                <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Appointment
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
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appointments as $key => $appointment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $appointment->patient_name }}</td>
                                            <td>{{ $appointment->doctor_name }}</td>
                                            <td>{{ $appointment->appointment_date->format('d M Y') }}</td>
                                            <td>{{ $appointment->appointment_time->format('h:i A') }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'badge-warning',
                                                        'confirmed' => 'badge-info',
                                                        'checked_in' => 'badge-primary',
                                                        'completed' => 'badge-success',
                                                        'cancelled' => 'badge-danger',
                                                    ];
                                                @endphp
                                                <span class="badge {{ $statusColors[$appointment->status] ?? 'badge-secondary' }}">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_appointment_{{ $appointment->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal per row -->
                                        <div id="delete_appointment_{{ $appointment->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to delete this Appointment?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" style="display:inline;">
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
                                            <td colspan="7" class="text-center">No appointments found.</td>
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