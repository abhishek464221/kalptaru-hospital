@extends('frontend.layouts.app')

@section('title', $doctor->full_name . ' - Medicare Plus')

@section('content')
<div class="uni-banner-default uni-background-1">
    <div class="container">
        <div class="page-title">
            <div class="page-title-inner">
                <h1>doctor details</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="/">home</a></li>
            <li><a href="{{ route('frontend.doctors.index') }}">our doctor</a></li>
            <li><a href="#">{{ $doctor->full_name }}</a></li>
        </ul>
    </div>
</div>

<div class="uni-doctor-details-body">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="uni-our-doctor-item-default">
                    <div class="item-img">
                        <img src="{{ $doctor->image }}" alt="{{ $doctor->full_name }}" class="img-responsive">
                    </div>
                    <div class="item-caption">
                        <div class="item-caption-head">
                            <div class="col-md-3 col-sm-3 col-xs-3 uni-clear-padding">
                                <div class="item-icons">
                                    <i class="fa fa-user-md" style="font-size: 30px; color: #1b8cff;"></i>
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
                                    <tr><td>Timing</td><td>{{ $doctor->opening_time ? date('h:i A', strtotime($doctor->opening_time)) : 'N/A' }} - {{ $doctor->closing_time ? date('h:i A', strtotime($doctor->closing_time)) : 'N/A' }}</td></tr>
                                    <tr><td>Phone</td><td>{{ $doctor->phone ?? 'N/A' }}</td></tr>
                                    <tr><td>Email</td><td>{{ $doctor->email ?? 'N/A' }}</td></tr>
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

            <div class="col-md-8">
                <div class="uni-doctor-details-right">
                    <div class="uni-doctor-details-summary">
                        <div class="uni-doctor-details-title">
                            <h3>Summary</h3>
                            <div class="uni-divider"></div>
                        </div>
                        <p>
                            {{ $doctor->qualification ?? 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi.' }}
                        </p>
                    </div>

                    <div class="uni-doctor-details-degrees">
                        <div class="uni-doctor-details-title">
                            <h3>education/degrees</h3>
                            <div class="uni-divider"></div>
                        </div>
                        <ul>
                            <li><span>Qualification:</span> {{ $doctor->qualification ?? 'Not specified' }}</li>
                            <li><span>Experience:</span> {{ $doctor->experience_years ?? 0 }} years</li>
                            <li><span>Specialization:</span> {{ $doctor->specialization }}</li>
                        </ul>
                    </div>

                    <div class="uni-doctor-details-contact">
                        <div class="uni-doctor-details-title">
                            <h3>Contact</h3>
                            <div class="uni-divider"></div>
                        </div>
                        <ul>
                            <li><i class="fa fa-phone" aria-hidden="true"></i> {{ $doctor->phone ?? 'N/A' }}</li>
                            <li><i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $doctor->email ?? 'N/A' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection