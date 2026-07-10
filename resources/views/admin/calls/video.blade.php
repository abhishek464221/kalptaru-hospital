@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Video Call</h4>
                <a href="{{ route('admin.chats.index') }}" class="btn btn-secondary mb-3">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="video-container position-relative" style="background:#000; border-radius:8px; min-height:400px;">
                            <video id="remote-video" autoplay style="width:100%; height:100%;"></video>
                            <video id="local-video" autoplay muted style="position:absolute; bottom:10px; right:10px; width:150px; border-radius:8px;"></video>
                        </div>
                        <div class="call-actions mt-4">
                            <button class="btn btn-danger btn-lg rounded-circle mr-3" id="end-call-btn" style="width:60px; height:60px;">
                                <i class="fa fa-phone"></i>
                            </button>
                            <span id="call-duration" class="ml-3" style="font-size:1.2rem;">0:00</span>
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
    // Demo simulation – you can integrate real WebRTC here
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

    // For demo, you can simulate local video
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(stream => {
                document.getElementById('local-video').srcObject = stream;
            })
            .catch(err => console.log('Camera access denied'));
    }
</script>
@endpush