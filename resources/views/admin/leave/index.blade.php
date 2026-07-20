@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Leave Requests</h4>
        <div class="row">
            <div class="col-md-8">
                <a href="{{ route('admin.leaves.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Leave Request
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
                                            <th>Leave Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Approved By</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($leaves as $key => $leave)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $leave->employee_name }}</td>
                                                <td>{{ ucfirst($leave->leave_type) }}</td>
                                                <td>{{ $leave->start_date->format('d M Y') }}</td>
                                                <td>{{ $leave->end_date->format('d M Y') }}</td>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'badge-warning',
                                                            'approved' => 'badge-success',
                                                            'rejected' => 'badge-danger',
                                                        ];
                                                    @endphp
                                                    <span class="badge {{ $statusColors[$leave->status] ?? 'badge-secondary' }}">
                                                        {{ ucfirst($leave->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $leave->approver_name }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.leaves.edit', $leave) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_leave_{{ $leave->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal per row -->
                                            <div id="delete_leave_{{ $leave->id }}" class="modal fade delete-modal" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                            <h3>Are you sure want to delete this Leave Request?</h3>
                                                            <div class="m-t-20">
                                                                <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                                <form action="{{ route('admin.leaves.destroy', $leave) }}" method="POST" style="display:inline;">
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
                                                <td colspan="8" class="text-center">No leave requests found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $leaves->appends(request()->query())->links() }}
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
                "{{ route('admin.leaves.index') }}",
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