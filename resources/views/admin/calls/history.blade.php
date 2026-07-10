@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Call History</h4>
                <a href="{{ route('admin.chats.index') }}" class="btn btn-secondary mb-3">
                    <i class="fa fa-arrow-left"></i> Back to Chat
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($calls->count())
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>With</th>
                                        <th>Type</th>
                                        <th>Direction</th>
                                        <th>Duration</th>
                                        <th>Date/Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calls as $call)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($call->user_id == Auth::id())
                                                {{ $call->receiver->name ?? 'Unknown' }}
                                            @else
                                                {{ $call->user->name ?? 'Unknown' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($call->call_type == 'video')
                                                <i class="fa fa-video-camera"></i> Video
                                            @elseif($call->call_type == 'audio')
                                                <i class="fa fa-phone"></i> Audio
                                            @else
                                                Missed
                                            @endif
                                        </td>
                                        <td>
                                            @if($call->user_id == Auth::id())
                                                <span class="badge badge-success">Outgoing</span>
                                            @else
                                                <span class="badge badge-info">Incoming</span>
                                            @endif
                                        </td>
                                        <td>{{ gmdate("i:s", $call->duration_seconds) }}</td>
                                        <td>{{ $call->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No call history yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection