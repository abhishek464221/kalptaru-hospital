@extends('frontend.layouts.app')

@section('title', 'Our Doctors - Medicare Plus')

@section('content')
<div class="uni-banner-default uni-background-1">
    <div class="container">
        <div class="page-title">
            <div class="page-title-inner">
                <h1>our doctor</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="/">home</a></li>
            <li><a href="#">page</a></li>
            <li><a href="#">our doctor</a></li>
        </ul>
    </div>
</div>

<div class="uni-our-doctor-body">
    <div class="container">
        <div class="uni-shortcode-tabs-default">
            <div class="uni-shortcode-tab-2">
                <div class="tabbable-panel">
                    <div class="tabbable-line">
                        <ul class="nav nav-tabs">
                            @forelse($specializations as $spec => $doctorsGroup)
                                <li class="{{ $loop->first ? 'active' : '' }}">
                                    <a href="#tab_{{ Str::slug($spec) }}" data-toggle="tab" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ strtolower($spec) }}
                                    </a>
                                </li>
                            @empty
                                <li class="active"><a href="#tab_default" data-toggle="tab">All</a></li>
                            @endforelse
                        </ul>

                        <div class="tab-content">
                            @forelse($specializations as $spec => $doctorsGroup)
                                <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="tab_{{ Str::slug($spec) }}">
                                    <div class="row">
                                        @foreach($doctorsGroup as $doctor)
                                        <div class="col-md-3 col-sm-6">
                                            <div class="uni-our-doctor-item-default">
                                                <div class="item-img">
                                                    <a href="{{ route('frontend.doctors.show', $doctor->id) }}">
                                                        <img src="{{ $doctor->image }}" alt="{{ $doctor->full_name }}" class="img-responsive">
                                                    </a>
                                                </div>
                                                <div class="item-caption">
                                                    <div class="item-caption-head">
                                                        <div class="col-md-3 col-sm-3 col-xs-3 uni-clear-padding">
                                                            <div class="item-icons">
                                                                <i class="fa fa-user-md" style="font-size: 24px; color: #1b8cff;"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 col-sm-9 col-xs-9 uni-clear-padding">
                                                            <div class="item-title">
                                                                <h4>{{ $doctor->full_name }}</h4>
                                                                <span>{{ $doctor->specialization }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-caption-info">
                                                        <table class="table">
                                                            <thead>
                                                                <tr><td>Degrees</td><td>{{ $doctor->qualification ?? 'N/A' }}</td></tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr><td>Experience</td><td>{{ $doctor->experience_years ?? 0 }} years</td></tr>
                                                                <tr><td>Fee</td><td>${{ number_format($doctor->consultation_fee ?? 0, 2) }}</td></tr>
                                                                <tr>
                                                                    <td>Available</td>
                                                                    <td>
                                                                        {{ !empty($doctor->available_days) ? implode(', ', $doctor->available_days) : 'N/A' }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <ul>
                                                                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                                                            <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="tab-pane active" id="tab_default">
                                    <p>No doctors found.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection