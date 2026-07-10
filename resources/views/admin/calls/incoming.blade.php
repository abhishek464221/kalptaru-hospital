@extends('admin.layouts.app')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Incoming Call</h4>
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
                            <i class="fa fa-user-circle fa-5x text-success"></i>
                            <h4 class="mt-2">John Doe</h4>
                            <p class="text-muted">Incoming Call...</p>
                            <div class="call-actions mt-4">
                                <button class="btn btn-success btn-lg rounded-circle mr-3" id="accept-call" style="width:60px; height:60px;">
                                    <i class="fa fa-phone"></i>
                                </button>
                                <button class="btn btn-danger btn-lg rounded-circle" id="reject-call" style="width:60px; height:60px;">
                                    <i class="fa fa-phone-slash"></i>
                                </button>
                            </div>
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
    $('#accept-call').on('click', function() {
        alert('Call accepted!');
        window.location.href = "{{ route('admin.calls.voice') }}";
    });

    $('#reject-call').on('click', function() {
        alert('Call rejected.');
        window.location.href = "{{ route('admin.calls.history') }}";
    });
</script>
@endpush