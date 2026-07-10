@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Compose Email</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.emails.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recipient Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="recipient_email" value="{{ old('recipient_email') }}" required>
                                @error('recipient_email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recipient Name</label>
                                <input class="form-control" type="text" name="recipient_name" value="{{ old('recipient_name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="subject" value="{{ old('subject') }}" required>
                        @error('subject')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Body <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="body" rows="8" required>{{ old('body') }}</textarea>
                        @error('body')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Attachments</label>
                        <input type="file" name="attachments[]" class="form-control-file" multiple accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.zip">
                        <small class="text-muted">Max 5MB per file. Supported: PDF, DOC, DOCX, PNG, JPG, JPEG, ZIP</small>
                        @error('attachments.*')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn"><i class="fa fa-send"></i> Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection