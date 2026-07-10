@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Gallery Item</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Hospital Building">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>File Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="file_type" id="file_type" required>
                                    <option value="image" {{ old('file_type') == 'image' ? 'selected' : '' }}>Image</option>
                                    <option value="video" {{ old('file_type') == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                                @error('file_type')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Album Name</label>
                                <input class="form-control" type="text" name="album_name" value="{{ old('album_name') }}" placeholder="e.g. Events 2024">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>File <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control-file" id="file_input" required accept="image/*,video/*">
                        <small class="text-muted" id="file_help">Supported: JPG, PNG, GIF, WEBP (Max 5MB) or MP4, AVI, MOV (Max 10MB)</small>
                        @error('file')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Order</label>
                        <input class="form-control" type="number" name="order" value="{{ old('order', 0) }}" min="0">
                        <small class="text-muted">Lower number appears first.</small>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="display-block">Featured</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Mark as Featured</label>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Add Gallery Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#file_type').on('change', function() {
            var type = $(this).val();
            var helpText = $('#file_help');
            var fileInput = $('#file_input');
            fileInput.val(''); // Clear previous selection
            
            if (type === 'image') {
                helpText.text('Supported: JPG, PNG, GIF, WEBP, SVG (Max 5MB)');
                fileInput.attr('accept', 'image/*');
            } else {
                helpText.text('Supported: MP4, AVI, MOV, WMV, FLV, WEBM (Max 10MB)');
                fileInput.attr('accept', 'video/*');
            }
        });
    });
</script>
@endpush