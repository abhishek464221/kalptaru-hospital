@extends('frontend.layouts.app')

@section('title', 'Contact Us - ' . ($settings['company_name'] ?? 'Kalpataru Hospital'))

@section('content')
<div class="uni-banner-default uni-background-1">
    <div class="container">
        <div class="page-title">
            <div class="page-title-inner">
                <h1>Contact Us</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </div>
</div>

<div class="uni-contact-us-body">
    <!-- MAP -->
    <div class="uni-about-map">
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1374128.6632203332!2d76.60741978323914!3d24.353861386838968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397957006b0dced1%3A0x1c398043e2b9eb18!2sKalpataru%20Multispeciality%20Hospital%20Ganjbasoda!5e1!3m2!1sen!2sin!4v1782983253504!5m2!1sen!2sin" height="450" style="border:0; width:100%;" allowfullscreen loading="lazy"></iframe>
    </div>

    <div class="uni-contact-us-body-content">
        <div class="container">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="row">
                <!-- Contact Form -->
                <div class="col-md-4">
                    <div class="uni-send-a-message">
                        <div class="uni-contact-title">
                            <h3>Send a Message</h3>
                            <div class="uni-line"></div>
                        </div>
                        <div class="uni-send-a-message-body">
                            <form action="{{ route('frontend.contact.store') }}" method="POST">
                                @csrf
                                <div class="input-group form-group">
                                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Your Name" required>
                                </div>
                                <div class="input-group form-group">
                                    <span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                                </div>
                                <div class="input-group form-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address">
                                </div>
                                <div class="input-group form-group">
                                    <textarea name="message" class="form-control" placeholder="Your Message / Query" rows="4">{{ old('message') }}</textarea>
                                </div>
                                <button type="submit" class="vk-btn vk-btn-send"><i class="fa fa-paper-plane"></i> Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4">
                    <div class="uni-contact-info">
                        <div class="uni-contact-title">
                            <h3>Contact Information</h3>
                            <div class="uni-line"></div>
                        </div>
                        <div class="uni-contact-info-body">
                            <!-- Address -->
                            <div class="item">
                                <div class="icon-holder">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                </div>
                                <div class="text-holder">
                                    <p>{{ $settings['address'] ?? 'Kalpataru Multispeciality Hospital, Ganjbasoda, Madhya Pradesh' }}</p>
                                    <span>India</span>
                                </div>
                            </div>

                            <!-- Receive Records -->
                            <div class="uni-receive-records">
                                <div class="uni-contact-info-title">
                                    <h4>Receive Records</h4>
                                    <div class="uni-divider"></div>
                                </div>
                                <div class="item">
                                    <div class="icon-holder">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                    </div>
                                    <div class="text-holder">
                                        <p>Call Us</p>
                                        <span>{{ $settings['phone'] ?? '(07594) 123 456' }}</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon-holder">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                    <div class="text-holder">
                                        <p>Send A Message</p>
                                        <span>{{ $settings['email'] ?? 'info@kalpataru.com' }}</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon-holder">
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                    </div>
                                    <div class="text-holder">
                                        <p>WhatsApp</p>
                                        <span>{{ $settings['whatsapp'] ?? '+91 98765 43210' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Care -->
                            <div class="uni-customer-care">
                                <div class="uni-contact-info-title">
                                    <h4>Customer Care</h4>
                                    <div class="uni-divider"></div>
                                </div>
                                <div class="item">
                                    <div class="icon-holder">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                    </div>
                                    <div class="text-holder">
                                        <p>Toll Free</p>
                                        <span>{{ $settings['toll_free'] ?? '1800-123-4567' }}</span>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon-holder">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                    <div class="text-holder">
                                        <p>Support Email</p>
                                        <span>{{ $settings['support_email'] ?? 'support@kalpataru.com' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Opening Hours -->
                <div class="col-md-4">
                    <div class="uni-contact-us-hours">
                        <div class="uni-contact-us-title">
                            <div class="icon">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                            </div>
                            <h4>Opening Hours</h4>
                        </div>
                        <div class="uni-contact-us-hours-content">
                            <table class="table">
                                <tr><td>Monday</td><td>{{ $settings['opening_monday'] ?? '8:00 AM - 8:00 PM' }}</td></tr>
                                <tr><td>Tuesday</td><td>{{ $settings['opening_tuesday'] ?? '8:00 AM - 8:00 PM' }}</td></tr>
                                <tr><td>Wednesday</td><td>{{ $settings['opening_wednesday'] ?? '8:00 AM - 8:00 PM' }}</td></tr>
                                <tr><td>Thursday</td><td>{{ $settings['opening_thursday'] ?? '8:00 AM - 8:00 PM' }}</td></tr>
                                <tr><td>Friday</td><td>{{ $settings['opening_friday'] ?? '8:00 AM - 8:00 PM' }}</td></tr>
                                <tr><td>Saturday</td><td>{{ $settings['opening_saturday'] ?? '8:00 AM - 5:00 PM' }}</td></tr>
                                <tr><td>Sunday</td><td>{{ $settings['opening_sunday'] ?? 'Emergency Only (24/7)' }}</td></tr>
                            </table>
                            <a href="#" class="book-appointment" data-toggle="modal" data-target="#appointmentModal">Book Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection