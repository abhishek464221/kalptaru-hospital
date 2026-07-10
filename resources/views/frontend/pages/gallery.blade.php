@extends('frontend.layouts.app')

@section('title', 'Gallery - Kalptaru Hospital')

@section('content')
<div class="uni-banner-default uni-background-1">
    <div class="container">
        <div class="page-title">
            <div class="page-title-inner">
                <h1>Gallery</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li><a href="#">Gallery</a></li>
        </ul>
    </div>
</div>

<div class="uni-gallery-body">
    <div class="container">
        <div class="uni-shortcode-tabs-default">
            <div class="uni-shortcode-tab-2">
                <div class="tabbable-panel">
                    <div class="tabbable-line">
                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" role="tablist">
                            @php $first = true; @endphp
                            @foreach($grouped as $albumName => $items)
                                <li role="presentation" class="{{ $first ? 'active' : '' }}">
                                    <a href="#tab_{{ Str::slug($albumName) }}" 
                                       aria-controls="tab_{{ Str::slug($albumName) }}" 
                                       role="tab" 
                                       data-toggle="tab"
                                       aria-expanded="{{ $first ? 'true' : 'false' }}">
                                        {{ ucfirst($albumName) }}
                                    </a>
                                </li>
                                @php $first = false; @endphp
                            @endforeach
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            @php $first = true; @endphp
                            @foreach($grouped as $albumName => $items)
                                <div role="tabpanel" 
                                     class="tab-pane {{ $first ? 'active' : '' }}" 
                                     id="tab_{{ Str::slug($albumName) }}">
                                    <div class="row" id="lightgallery-{{ Str::slug($albumName) }}">
                                        @foreach($items as $gallery)
                                            <div class="col-md-4 col-sm-6" 
                                                 data-src="{{ $gallery->file_url }}"
                                                 @if($gallery->file_type == 'video')
                                                 data-sub-html="<video controls><source src='{{ $gallery->file_url }}' type='video/mp4'></video>"
                                                 @endif
                                                 >
                                                <div class="item-img">
                                                    @if($gallery->file_type == 'image')
                                                        <img src="{{ $gallery->file_url }}" 
                                                             alt="{{ $gallery->title ?? 'Gallery Image' }}" 
                                                             class="img-responsive">
                                                    @else
                                                        <!-- Video thumbnail - aap chahe toh video ka thumbnail bana sakte hain, 
                                                             otherwise ek placeholder image ya video icon -->
                                                        <div style="background:#000; height:200px; display:flex; align-items:center; justify-content:center; color:#fff;">
                                                            <i class="fa fa-play-circle" style="font-size:48px;"></i>
                                                            <span style="margin-left:10px;">{{ $gallery->title ?? 'Video' }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @php $first = false; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Agar aap LightGallery use kar rahe hain toh usko initialize karein -->
<script>
    $(document).ready(function() {
        @foreach($grouped as $albumName => $items)
            $('#lightgallery-{{ Str::slug($albumName) }}').lightGallery({
                selector: '.col-md-4',
                thumbnail: true,
                animateThumb: false,
                showThumbByDefault: false
            });
        @endforeach
    });
</script>
@endpush