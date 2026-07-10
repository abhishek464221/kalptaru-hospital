@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Call Logs</h4>
                <a href="{{ route('admin.calls.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Call Log
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <form action="{{ route('admin.calls.index') }}" method="GET" class="form-inline">
                            <div class="form-group mr-2">
                                <label class="mr-1">Type:</label>
                                <select name="call_type" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    <option value="incoming" {{ request('call_type') == 'incoming' ? 'selected' : '' }}>Incoming</option>
                                    <option value="outgoing" {{ request('call_type') == 'outgoing' ? 'selected' : '' }}>Outgoing</option>
                                    <option value="missed" {{ request('call_type') == 'missed' ? 'selected' : '' }}>Missed</option>
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label class="mr-1">Employee:</label>
                                <select name="employee_id" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label class="mr-1">Follow Up:</label>
                                <select name="follow_up" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    <option value="yes" {{ request('follow_up') == 'yes' ? 'selected' : '' }}>Required</option>
                                    <option value="no" {{ request('follow_up') == 'no' ? 'selected' : '' }}>Not Required</option>
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label class="mr-1">From:</label>
                                <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                            </div>
                            <div class="form-group mr-2">
                                <label class="mr-1">To:</label>
                                <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mr-2">Filter</button>
                            <a href="{{ route('admin.calls.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calls Table -->
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
                                        <th>Caller</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Date/Time</th>
                                        <th>Duration</th>
                                        <th>Follow Up</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($calls as $key => $call)
                                        <tr>
                                            <td>{{ $calls->firstItem() + $key }}</td>
                                            <td>{{ $call->employee_name }}</td>
                                            <td>{{ $call->caller_name ?? 'N/A' }}</td>
                                            <td>{{ $call->caller_phone }}</td>
                                            <td>{!! $call->call_type_badge !!}</td>
                                            <td>{{ $call->call_datetime->format('d M Y h:i A') }}</td>
                                            <td>{{ $call->duration_formatted }}</td>
                                            <td>{!! $call->follow_up_status !!}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.calls.edit', $call) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_call_{{ $call->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal per row -->
                                        <div id="delete_call_{{ $call->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to delete this Call Log?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.calls.destroy', $call) }}" method="POST" style="display:inline;">
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
                                            <td colspan="9" class="text-center">No call logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $calls->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection