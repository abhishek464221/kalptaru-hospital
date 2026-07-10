@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Contact Messages</h4>
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
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Submitted At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $key => $contact)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->phone ?? 'N/A' }}</td>
                                            <td>{{ $contact->email ?? 'N/A' }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($contact->message, 50) }}</td>
                                            <td>
                                                @if($contact->status == 'new')
                                                    <span class="badge badge-primary">New</span>
                                                @elseif($contact->status == 'read')
                                                    <span class="badge badge-success">Read</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $contact->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $contact->created_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No messages found.</td>
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