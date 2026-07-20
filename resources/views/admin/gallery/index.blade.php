@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <h4 class="page-title">Gallery</h4>
        <div class="row">
            <div class="col-md-8">
                
                <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Add Gallery Item
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <input type="text"
                    id="search"
                    class="form-control"
                    placeholder="Search..."
                    value="{{ request('search') }}">
            </div>
        </div>
        <div class="row">
            @forelse($galleries as $gallery)
                <div class="col-md-3 col-sm-6">
                    <div class="card gallery-card">
                        <div class="card-body">
                            <div class="gallery-img">
                                @if($gallery->file_type === 'image')
                                    <img src="{{ $gallery->file_url }}" alt="{{ $gallery->title }}" class="img-fluid">
                                @else
                                    <video controls class="img-fluid" style="max-height: 200px;">
                                        <source src="{{ $gallery->file_url }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>
                            <div class="gallery-info mt-2">
                                <h6 class="mb-1">{{ $gallery->title ?? 'Untitled' }}</h6>
                                <small class="text-muted">
                                    <i class="{{ $gallery->file_icon }}"></i> {{ ucfirst($gallery->file_type) }}
                                    @if($gallery->album_name)
                                        <span class="badge badge-info">{{ $gallery->album_name }}</span>
                                    @endif
                                </small>
                                <br>
                                {!! $gallery->featured_badge !!}
                                <span class="badge badge-secondary">Order: {{ $gallery->order }}</span>
                            </div>
                            <div class="gallery-actions mt-2 text-center">
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_gallery_{{ $gallery->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @if($gallery->is_featured)
                                    <a href="{{ route('admin.galleries.toggle-featured', $gallery) }}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-star"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.galleries.toggle-featured', $gallery) }}" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-star-o"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal per row -->
                <div id="delete_gallery_{{ $gallery->id }}" class="modal fade delete-modal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <img src="{{ asset('admin/assets/img/sent.png') }}" alt="" width="50" height="46">
                                <h3>Are you sure want to delete this Gallery Item?</h3>
                                <div class="m-t-20">
                                    <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" style="display:inline;">
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
                <div class="col-12">
                    <div class="alert alert-info">No gallery items found.</div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .gallery-card {
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .gallery-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .gallery-img {
        max-height: 200px;
        overflow: hidden;
        border-radius: 5px;
        background: #f0f0f0;
    }
    .gallery-img img,
    .gallery-img video {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .gallery-info h6 {
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .gallery-actions .btn {
        margin: 2px;
    }
</style>
@endpush