@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Chat</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Users</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center chat-user" data-user-id="{{ $user->id }}">
                                    <a href="{{ route('admin.chats.show', $user) }}" class="text-dark text-decoration-none w-100">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="position-relative">
                                                    <img src="{{ asset('uploads/users/'.$user->image) }}" alt="{{ $user->name }}" class="rounded-circle" width="40" height="40">
                                                    <span class="status-dot status-{{ $user->isOnline() ? 'online' : 'offline' }}"></span>
                                                </div>
                                                <div class="ml-2">
                                                    <strong>{{ $user->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        @if(isset($latestMessages[$user->id]))
                                                            {{ Str::limit($latestMessages[$user->id]->message, 30) }}
                                                        @else
                                                            No messages
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            @if(isset($unreadCounts[$user->id]) && $unreadCounts[$user->id] > 0)
                                                <span class="badge badge-danger badge-pill">{{ $unreadCounts[$user->id] }}</span>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item text-center">No users available to chat.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fa fa-comments fa-3x text-muted mb-3"></i>
                        <h5>Select a user to start chatting</h5>
                        <p class="text-muted">Choose a user from the left panel.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }
    .status-online {
        background: #28a745;
    }
    .status-offline {
        background: #6c757d;
    }
    .chat-user:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush