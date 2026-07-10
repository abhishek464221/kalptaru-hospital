@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Email Details</h4>
                <a href="{{ route('admin.emails.index') }}" class="btn btn-secondary mb-3">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                @if($email->status == 'failed')
                    <a href="{{ route('admin.emails.resend', $email) }}" class="btn btn-warning mb-3" onclick="return confirm('Are you sure you want to resend this email?')">
                        <i class="fa fa-refresh"></i> Resend
                    </a>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Recipient:</strong> {{ $email->recipient_name ?? 'N/A' }}</p>
                                <p><strong>Recipient Email:</strong> {{ $email->recipient_email }}</p>
                                <p><strong>Subject:</strong> {{ $email->subject }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong> {!! $email->status_badge !!}</p>
                                <p><strong>Sent At:</strong> {{ $email->sent_at ? $email->sent_at->format('d M Y h:i A') : '-' }}</p>
                                <p><strong>Created At:</strong> {{ $email->created_at->format('d M Y h:i A') }}</p>
                            </div>
                        </div>
                        @if($email->error_message)
                            <div class="alert alert-danger">
                                <strong>Error:</strong> {{ $email->error_message }}
                            </div>
                        @endif
                        @if($email->attachments)
                            <div class="mt-3">
                                <strong>Attachments:</strong>
                                <ul>
                                    @foreach($email->attachments as $attachment)
                                        <li>
                                            <a href="{{ asset('storage/' . $attachment) }}" target="_blank">
                                                {{ basename($attachment) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <hr>
                        <div class="mt-3">
                            <h5>Email Body</h5>
                            <div class="border p-3 bg-light" style="min-height: 200px;">
                                {!! nl2br(e($email->body)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection