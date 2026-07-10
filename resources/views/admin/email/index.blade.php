@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Email Logs</h4>
                <a href="{{ route('admin.emails.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Compose Email
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <form action="{{ route('admin.emails.index') }}" method="GET" class="form-inline">
                            <div class="form-group mr-2">
                                <label class="mr-1">Status:</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">All</option>
                                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="queued" {{ request('status') == 'queued' ? 'selected' : '' }}>Queued</option>
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
                            <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emails Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Recipient</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Sent At</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($emails as $key => $email)
                                        <tr>
                                            <td>{{ $emails->firstItem() + $key }}</td>
                                            <td>
                                                <strong>{{ $email->recipient_name ?? 'N/A' }}</strong>
                                                <br>
                                                <small>{{ $email->recipient_email }}</small>
                                            </td>
                                            <td>{{ Str::limit($email->subject, 40) }}</td>
                                            <td>{!! $email->status_badge !!}</td>
                                            <td>{{ $email->sent_at ? $email->sent_at->format('d M Y h:i A') : '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.emails.show', $email) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if($email->status == 'failed')
                                                    <a href="{{ route('admin.emails.resend', $email) }}" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to resend this email?')">
                                                        <i class="fa fa-refresh"></i>
                                                    </a>
                                                @endif
                                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_email_{{ $email->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Delete Modal per row -->
                                        <div id="delete_email_{{ $email->id }}" class="modal fade delete-modal" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                                        <h3>Are you sure want to delete this Email?</h3>
                                                        <div class="m-t-20">
                                                            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                                            <form action="{{ route('admin.emails.destroy', $email) }}" method="POST" style="display:inline;">
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
                                            <td colspan="6" class="text-center">No emails found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $emails->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection