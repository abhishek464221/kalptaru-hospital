@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Subscribers</h4>
                <a href="{{ route('admin.subscribers.export') }}" class="btn btn-success mb-3">
                    <i class="fa fa-download"></i> Export CSV
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <form action="{{ route('admin.subscribers.index') }}" method="GET" class="form-inline">
                            <div class="form-group mr-2">
                                <label class="mr-1">Status:</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="form-group mr-2">
                                <label class="mr-1">Search:</label>
                                <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}" placeholder="Email or Name">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mr-2">Filter</button>
                            <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscribers Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Subscribed At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subscribers as $key => $subscriber)
                                        <tr>
                                            <td>{{ $subscribers->firstItem() + $key }}</td>
                                            <td>{{ $subscriber->email }}</td>
                                            <td>{{ $subscriber->name ?? 'N/A' }}</td>
                                            <td>
                                                @if($subscriber->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $subscriber->subscribed_at->format('d M Y h:i A') }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#toggle_subscriber_{{ $subscriber->id }}">
                                                    <i class="fa fa-{{ $subscriber->is_active ? 'ban' : 'check' }}"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_subscriber_{{ $subscriber->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Toggle Modal -->
                                        <div id="toggle_subscriber_{{ $subscriber->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to {{ $subscriber->is_active ? 'inactive' : 'active' }} this subscriber?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.subscribers.toggle', $subscriber) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary">Yes, Toggle</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div id="delete_subscriber_{{ $subscriber->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to delete this Subscriber?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" style="display:inline;">
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
                                            <td colspan="6" class="text-center">No subscribers found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $subscribers->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection