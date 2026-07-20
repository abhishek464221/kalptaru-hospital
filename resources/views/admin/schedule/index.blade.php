@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Schedules</h4>
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Schedule
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
                                            <th>Doctor</th>
                                            <th>Day</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($schedules as $key => $schedule)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $schedule->employee_name ?? '-' }}</td>
                                                <td>{{ $schedule->doctor_name ?? '-' }}</td>
                                                <td>{{ ucfirst($schedule->day_of_week) }}</td>
                                                <td>{{ $schedule->start_time ? $schedule->start_time->format('h:i A') : '-' }}</td>
                                                <td>{{ $schedule->end_time ? $schedule->end_time->format('h:i A') : '-' }}</td>
                                                <td>
                                                    @if($schedule->is_working_day)
                                                        <span class="badge badge-success">Working</span>
                                                    @else
                                                        <span class="badge badge-danger">Off</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_schedule_{{ $schedule->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal per row -->
                                            <div id="delete_schedule_{{ $schedule->id }}" class="modal fade delete-modal" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                            <h3>Are you sure want to delete this Schedule?</h3>
                                                            <div class="m-t-20">
                                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" style="display:inline;">
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
                                                <td colspan="8" class="text-center">No schedules found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $schedules->appends(request()->query())->links() }}
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
                "{{ route('admin.schedules.index') }}",
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