@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Attendance</h4>
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('admin.attendances.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Mark Attendance
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <input type="text"
                    id="search"
                    class="form-control"
                    placeholder="Search..."
                    value="{{ request('search') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <div id="table-data">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Date</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendances as $key => $attendance)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $attendance->employee_name }}</td>
                                                <td>{{ $attendance->attendance_date->format('d M Y') }}</td>
                                                <td>{{ $attendance->check_in ? $attendance->check_in->format('h:i A') : '-' }}</td>
                                                <td>{{ $attendance->check_out ? $attendance->check_out->format('h:i A') : '-' }}</td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'present' => 'badge-success',
                                                            'absent' => 'badge-danger',
                                                            'leave' => 'badge-warning',
                                                            'half_day' => 'badge-info',
                                                            'holiday' => 'badge-secondary',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$attendance->status] ?? 'badge-secondary' }}">
                                                        {{ ucfirst($attendance->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.attendances.edit', $attendance) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_attendance_{{ $attendance->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal per row -->
                                            <div id="delete_attendance_{{ $attendance->id }}" class="modal fade delete-modal" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                            <h3>Are you sure want to delete this Attendance?</h3>
                                                            <div class="m-t-20">
                                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                                <form action="{{ route('admin.attendances.destroy', $attendance) }}" method="POST" style="display:inline;">
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
                                                <td colspan="7" class="text-center">No attendance records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $attendances->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let timer;

    $('#search').keyup(function(){

        clearTimeout(timer);

        timer=setTimeout(function(){

            $.get(
                "{{ route('admin.attendances.index') }}",
                {
                    search:$('#search').val()
                },
                function(response){

                    $('#table-data').html(
                        $(response).find('#table-data').html()
                    );

                }
            );

        },400);

    });

    $(document).on('click','.pagination a',function(e){

        e.preventDefault();

        $.get(
            $(this).attr('href'),
            {
                search:$('#search').val()
            },
            function(response){

                $('#table-data').html(
                    $(response).find('#table-data').html()
                );

            }
        );

    });

</script>
@endpush