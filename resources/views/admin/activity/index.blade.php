@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Activity Logs</h4>
                <div class="float-right">
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#clearAllModal">
                        <i class="fa fa-trash"></i> Clear All
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <form action="{{ route('admin.activities.index') }}" method="GET" class="form-inline">
                            <div class="form-group mr-2">
                                <label class="mr-1">Module:</label>
                                <select name="module" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                            {{ ucfirst($module) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label class="mr-1">Action:</label>
                                <select name="action" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                            {{ ucfirst($action) }}
                                        </option>
                                    @endforeach
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
                            <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Module</th>
                                        <th>Description</th>
                                        <th>IP Address</th>
                                        <th>Date/Time</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activities as $key => $activity)
                                        <tr>
                                            <td>{{ $activities->firstItem() + $key }}</td>
                                            <td>{{ $activity->user_name }}</td>
                                            <td>
                                                <span class="badge {{ $activity->action_color }}">
                                                    {{ ucfirst($activity->action) }}
                                                </span>
                                            </td>
                                            <td>{{ ucfirst($activity->module ?? 'N/A') }}</td>
                                            <td>{{ Str::limit($activity->description, 50) }}</td>
                                            <td>{{ $activity->ip_address ?? '-' }}</td>
                                            <td>{{ $activity->created_at->format('d M Y H:i:s') }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_activity_{{ $activity->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal per row -->
                                        <div id="delete_activity_{{ $activity->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to delete this Activity Log?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" style="display:inline;">
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
                                            <td colspan="8" class="text-center">No activity logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $activities->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clear All Modal -->
<div id="clearAllModal" class="modal fade delete-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="{{ asset('assets/img/sent.png') }}" alt="" width="50" height="46">
                <h3>Are you sure want to clear all activity logs?</h3>
                <p>This action cannot be undone.</p>
                <div class="m-t-20">
                    <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                    <form action="{{ route('admin.activities.clear') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Clear All</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection