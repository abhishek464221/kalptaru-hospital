@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Voice Call</h4>
                <a href="{{ route('admin.chats.index') }}" class="btn btn-secondary mb-3">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="caller-info mb-4">
                            <i class="fa fa-user-circle fa-5x text-primary"></i>
                            <h4 class="mt-2">{{ Auth::user()->name }}</h4>
                            <p class="text-muted">Calling...</p>
                        </div>
                        <div class="call-actions">
                            <button class="btn btn-danger btn-lg rounded-circle mr-3" id="end-call-btn" style="width:60px; height:60px;">
                                <i class="fa fa-phone"></i>
                            </button>
                        </div>
                        <div id="call-duration" class="mt-3" style="font-size:1.2rem;">0:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple simulation for demo – you can replace with real WebRTC logic
    let seconds = 0;
    const durationEl = document.getElementById('call-duration');
    const interval = setInterval(() => {
        seconds++;
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        durationEl.textContent = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }, 1000);

    $('#end-call-btn').on('click', function() {
        clearInterval(interval);
        alert('Call ended. Duration: ' + durationEl.textContent);
        window.location.href = "{{ route('admin.calls.history') }}";
    });
</script>
@endpush