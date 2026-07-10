@extends('frontend.layouts.app')

@section('title', 'About Us - ' . ($settings['company_name'] ?? 'Kalpataru Hospital'))

@section('content')
<div class="uni-banner-default uni-background-1">
    <div class="container">
        <div class="page-title">
            <div class="page-title-inner">
                <h1>About Us</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">About</a></li>
        </ul>
    </div>
</div>

<div class="uni-about-body">

    <!-- ============================= -->
    <!-- WHO WE ARE – Real Content      -->
    <!-- ============================= -->
    <div class="uni-about-who-are-you">
        <div class="container">
            <div class="uni-services-title">
                <h3>Who We Are</h3>
                <div class="uni-underline"></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="uni-about-who-are-you-left">
                        <img src="{{ asset('frontend/images/about/img.jpg') }}" alt="About Kalpataru Hospital" class="img-responsive">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="uni-about-who-are-you-right">
                        <p>
                            {{ $settings['about_description'] ?? 'Kalpataru Multispeciality Hospital is a trusted healthcare institution dedicated to providing compassionate, high-quality medical care to our community. With a team of experienced doctors, state-of-the-art technology, and a patient-centric approach, we strive to heal, comfort, and improve the lives of every individual who walks through our doors. Our mission is to deliver affordable, accessible, and excellent healthcare services with integrity and respect.' }}
                        </p>
                        <h4>Our Core Values</h4>
                        <ul>
                            <li><strong>Compassion:</strong> We treat every patient with kindness and empathy.</li>
                            <li><strong>Excellence:</strong> We pursue the highest standards in medical care.</li>
                            <li><strong>Integrity:</strong> We act with honesty and transparency.</li>
                            <li><strong>Innovation:</strong> We embrace modern technology and continuous learning.</li>
                            <li><strong>Teamwork:</strong> We collaborate across disciplines for holistic care.</li>
                            <li><strong>Community:</strong> We are committed to the health of our society.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- OUR DOCTORS – Dynamic          -->
    <!-- ============================= -->
    <div class="uni-shortcode-team-2 uni-background-2">
        <div class="container">
            <div class="uni-services-title">
                <h3>Our Expert Doctors</h3>
                <div class="uni-underline"></div>
            </div>
            <div class="uni-owl-four-item owl-carousel owl-theme">
                @forelse($aboutDoctors as $doctor)
                    <div class="item">
                        <div class="uni-team-default">
                            <div class="item-img">
                                <img src="{{ $doctor->image ?? asset('frontend/images/team/default.png') }}" alt="{{ $doctor->full_name }}" class="img-responsive">
                            </div>
                            <div class="item-caption">
                                <div class="col-md-3 col-sm-3 col-xs-3 uni-clear-padding">
                                    <div class="item-icons">
                                        <i class="fa fa-user-md" style="font-size: 30px; color: #1b8cff;"></i>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-9 uni-clear-padding">
                                    <div class="item-title">
                                        <h4>{{ $doctor->full_name }}</h4>
                                        <span>{{ $doctor->specialization ?? $doctor->department->name ?? 'Specialist' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="item">
                        <p>No doctors available. Please check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- WHY CHOOSE US – Real Features  -->
    <!-- ============================= -->
    <div class="uni-shortcode-icons-box-3">
        <div class="container">
            <div class="uni-services-title">
                <h3>Why Choose Kalpataru?</h3>
                <div class="uni-underline"></div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="uni-shortcode-icons-box-3-default">
                        <div class="item-icons">
                            <i class="fa fa-user-md" aria-hidden="true"></i>
                        </div>
                        <div class="item-caption">
                            <h4>Qualified & Experienced Doctors</h4>
                            <div class="uni-line"></div>
                            <p>
                                Our team comprises highly skilled specialists with years of experience in their respective fields, ensuring you receive the best possible care.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="uni-shortcode-icons-box-3-default">
                        <div class="item-icons">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </div>
                        <div class="item-caption">
                            <h4>24/7 Emergency & OPD Services</h4>
                            <div class="uni-line"></div>
                            <p>
                                We are always ready to serve you – round-the-clock emergency care and extended outpatient hours to fit your busy schedule.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="uni-shortcode-icons-box-3-default">
                        <div class="item-icons">
                            <i class="fa fa-hospital-o" aria-hidden="true"></i>
                        </div>
                        <div class="item-caption">
                            <h4>Modern Equipment & Facilities</h4>
                            <div class="uni-line"></div>
                            <p>
                                We invest in cutting-edge medical technology – from advanced imaging to minimally invasive surgical tools – for accurate diagnosis and effective treatment.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="uni-shortcode-icons-box-3-default">
                        <div class="item-icons">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </div>
                        <div class="item-caption">
                            <h4>Patient-Centric Approach</h4>
                            <div class="uni-line"></div>
                            <p>
                                Your health and comfort are our top priorities. We listen, explain, and involve you in every step of your treatment journey.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="uni-shortcode-icons-box-3-default">
                        <div class="item-icons">
                            <i class="fa fa-ambulance" aria-hidden="true"></i>
                        </div>
                        <div class="item-caption">
                            <h4>Rapid Response & Ambulance Services</h4>
                            <div class="uni-line"></div>
                            <p>
                                Our well-equipped ambulances and trained paramedics ensure quick response in emergencies, bringing critical care to your doorstep.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="uni-shortcode-icons-box-3-default">
                        <div class="item-icons">
                            <i class="fa fa-commenting" aria-hidden="true"></i>
                        </div>
                        <div class="item-caption">
                            <h4>Compassionate Support Team</h4>
                            <div class="uni-line"></div>
                            <p>
                                From admission to discharge, our dedicated staff offers warm, empathetic support to make your hospital experience as comfortable as possible.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- OUR SERVICES – Real Descriptions -->
    <!-- ============================= -->
    <div class="uni-our-services-2 uni-background-4">
        <div class="container">
            <div class="uni-services-title">
                <h3>Our Specialized Services</h3>
                <div class="uni-underline"></div>
            </div>

            <div class="uni-our-service-2-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="tab-nav">
                            <ul class="nav-pills nav-stacked">
                                <li class="active"><a href="#tab_a" data-toggle="pill">Cardiology & Heart Care</a></li>
                                <li><a href="#tab_b" data-toggle="pill">Ophthalmology & Eye Surgery</a></li>
                                <li><a href="#tab_c" data-toggle="pill">General Medicine & Health Checkups</a></li>
                                <li><a href="#tab_d" data-toggle="pill">Oncology & Cancer Treatment</a></li>
                                <li><a href="#tab_e" data-toggle="pill">Dermatology & Skin Care</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- Cardiology -->
                            <div class="tab-pane active" id="tab_a">
                                <div class="uni-our-service-2-content-default">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="item-img">
                                                <img src="{{ asset('frontend/images/services/img.jpg') }}" alt="Cardiology" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="item-caption">
                                                <div class="item-caption-title">
                                                    <h3>Cardiology & Heart Care</h3>
                                                    <div class="uni-line"></div>
                                                </div>
                                                <p>
                                                    Our cardiology department offers comprehensive diagnosis and treatment for all heart conditions – from hypertension and coronary artery disease to heart failure. We perform advanced procedures like angioplasty, stenting, and cardiac rehabilitation. Our team of cardiologists and cardiac surgeons work together to ensure the best outcomes for your heart health.
                                                </p>
                                                <ul>
                                                    <li>Non-invasive diagnostic tests (ECG, Echo, TMT)</li>
                                                    <li>Interventional cardiology (Angiography, Angioplasty)</li>
                                                    <li>Cardiac surgery (Bypass, Valve replacement)</li>
                                                    <li>Post-operative rehabilitation & lifestyle guidance</li>
                                                    <li>Preventive cardiology & risk assessment</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ophthalmology -->
                            <div class="tab-pane" id="tab_b">
                                <div class="uni-our-service-2-content-default">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="item-img">
                                                <img src="{{ asset('frontend/images/services/img1.jpg') }}" alt="Ophthalmology" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="item-caption">
                                                <div class="item-caption-title">
                                                    <h3>Ophthalmology & Eye Surgery</h3>
                                                    <div class="uni-line"></div>
                                                </div>
                                                <p>
                                                    Our eye care centre provides state-of-the-art diagnosis and treatment for a wide range of vision problems – including cataracts, glaucoma, refractive errors, and corneal diseases. We specialize in advanced surgical techniques like phacoemulsification, LASIK, and corneal transplants, ensuring clear vision and improved quality of life.
                                                </p>
                                                <ul>
                                                    <li>Comprehensive eye examinations</li>
                                                    <li>Cataract surgery with premium IOLs</li>
                                                    <li>LASIK and refractive surgeries</li>
                                                    <li>Glaucoma management</li>
                                                    <li>Corneal transplant and external eye diseases</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- General Medicine -->
                            <div class="tab-pane" id="tab_c">
                                <div class="uni-our-service-2-content-default">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="item-img">
                                                <img src="{{ asset('frontend/images/services/img2.jpg') }}" alt="General Medicine" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="item-caption">
                                                <div class="item-caption-title">
                                                    <h3>General Medicine & Health Checkups</h3>
                                                    <div class="uni-line"></div>
                                                </div>
                                                <p>
                                                    Our general medicine department offers comprehensive healthcare for adults – from routine check-ups and management of chronic diseases like diabetes, hypertension, and thyroid disorders to acute illness care. We focus on preventive health, early detection, and personalized treatment plans to keep you healthy.
                                                </p>
                                                <ul>
                                                    <li>Annual health checkups & wellness packages</li>
                                                    <li>Management of diabetes, hypertension, asthma</li>
                                                    <li>Infectious disease treatment</li>
                                                    <li>Nutrition & lifestyle counselling</li>
                                                    <li>Geriatric care and elderly wellness</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Oncology -->
                            <div class="tab-pane" id="tab_d">
                                <div class="uni-our-service-2-content-default">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="item-img">
                                                <img src="{{ asset('frontend/images/services/img3.jpg') }}" alt="Oncology" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="item-caption">
                                                <div class="item-caption-title">
                                                    <h3>Oncology & Cancer Treatment</h3>
                                                    <div class="uni-line"></div>
                                                </div>
                                                <p>
                                                    Our oncology centre provides multidisciplinary care for all types of cancer. We offer medical oncology (chemotherapy, targeted therapy, immunotherapy), radiation oncology, and surgical oncology. Our tumor board reviews each case to create a personalized treatment plan, and we provide supportive care including nutrition, pain management, and psychological counselling.
                                                </p>
                                                <ul>
                                                    <li>Early cancer screening and diagnosis</li>
                                                    <li>Chemotherapy and targeted therapy</li>
                                                    <li>Radiation therapy (external beam, brachytherapy)</li>
                                                    <li>Surgical oncology and minimally invasive tumor removal</li>
                                                    <li>Palliative care and survivorship programmes</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Dermatology -->
                            <div class="tab-pane" id="tab_e">
                                <div class="uni-our-service-2-content-default">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="item-img">
                                                <img src="{{ asset('frontend/images/services/img3.jpg') }}" alt="Dermatology" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="item-caption">
                                                <div class="item-caption-title">
                                                    <h3>Dermatology & Skin Care</h3>
                                                    <div class="uni-line"></div>
                                                </div>
                                                <p>
                                                    Our dermatology clinic provides expert care for all skin, hair, and nail conditions – including acne, eczema, psoriasis, vitiligo, and skin infections. We also offer cosmetic dermatology services such as laser treatments, chemical peels, and anti-aging therapies. We use the latest technology for safe and effective results.
                                                </p>
                                                <ul>
                                                    <li>Medical dermatology (acne, eczema, psoriasis)</li>
                                                    <li>Cosmetic dermatology (laser, fillers, peels)</li>
                                                    <li>Skin cancer screening and mole evaluation</li>
                                                    <li>Hair and scalp disorders</li>
                                                    <li>Paediatric dermatology</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- DEPARTMENTS + TESTIMONIALS + OPENING HOURS (Dynamic Departments) -->
    <!-- ============================= -->
    <div class="uni-services-de-test-hours">
        <div class="container">
            <div class="row">
                <!-- DEPARTMENTS (Dynamic from DB) -->
                <div class="col-md-4">
                    <div class="uni-services-department">
                        <div class="uni-services-title">
                            <h3>Our Departments</h3>
                            <div class="uni-line"></div>
                        </div>
                        <div class="uni-services-department-content">
                            <div class="accordion-default">
                                <div class="accordion-icons-img">
                                    <div class="accordion">
                                        @forelse($aboutDepartments as $dept)
                                            <div class="accordion-item">
                                                <div class="accordion-toggle {{ $loop->first ? 'active' : '' }}">
                                                    <div class="accordion-icosn">
                                                        @php
                                                            $iconMap = [
                                                                'cardiology' => 'icon-5.png',
                                                                'neurology' => 'icon-4.png',
                                                                'orthopedics' => 'icon-3.png',
                                                                'cancer' => 'icon-2.png',
                                                                'ophthalmology' => 'icon-1.png',
                                                                'respiratory' => 'icon.png',
                                                            ];
                                                            $iconFile = $iconMap[strtolower($dept->name)] ?? 'icon.png';
                                                        @endphp
                                                        <img src="{{ asset('frontend/images/icons_box/icon_1/' . $iconFile) }}" alt="{{ $dept->name }}">
                                                    </div>
                                                    <h4>{{ $dept->name }}</h4>
                                                </div>
                                                <div class="accordion-content" style="{{ $loop->first ? 'display: block' : 'display: none' }}">
                                                    <p>{{ $dept->description ?? 'We provide comprehensive care in this specialty with modern facilities and expert consultants.' }}</p>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="accordion-item">
                                                <div class="accordion-toggle active">
                                                    <div class="accordion-icosn">
                                                        <img src="{{ asset('frontend/images/icons_box/icon_1/icon.png') }}" alt="">
                                                    </div>
                                                    <h4>No Departments Listed</h4>
                                                </div>
                                                <div class="accordion-content" style="display: block">
                                                    <p>Please add departments from the admin panel.</p>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TESTIMONIALS (Real patient feedback) -->
                <div class="col-md-4">
                    <div class="uni-services-testimonials">
                        <div class="uni-services-title">
                            <h3>What Our Patients Say</h3>
                            <div class="uni-line"></div>
                        </div>
                        <div class="uni-services-testimonials-content">
                            <div class="uni-owl-one-item owl-carousel owl-theme">
                                <div class="item">
                                    <div class="uni-shortcode-testimonials-default">
                                        <div class="item-info">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="item-info-img">
                                                        <img src="{{ asset('frontend/images/testimonial/img.png') }}" alt="Patient" class="img-responsive">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="item-info-title">
                                                        <h4>Ramesh Gupta</h4>
                                                        <p class="testimonial_subtitle">Cardiac Surgery Patient</p>
                                                    </div>
                                                    <div class="uni-divider"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-caption">
                                            <p>"The cardiology team at Kalpataru gave me a new lease on life. Their expertise and care made my recovery smooth. I highly recommend this hospital."</p>
                                        </div>
                                    </div>
                                    <div class="uni-shortcode-testimonials-default">
                                        <div class="item-info">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="item-info-img">
                                                        <img src="{{ asset('frontend/images/testimonial/img1.png') }}" alt="Patient" class="img-responsive">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="item-info-title">
                                                        <h4>Sunita Sharma</h4>
                                                        <p class="testimonial_subtitle">Knee Replacement Patient</p>
                                                    </div>
                                                    <div class="uni-divider"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-caption">
                                            <p>"I can finally walk without pain! The orthopedic surgeons and physiotherapists were amazing. Thank you Kalpataru for giving me back my mobility."</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="uni-shortcode-testimonials-default">
                                        <div class="item-info">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="item-info-img">
                                                        <img src="{{ asset('frontend/images/testimonial/img.png') }}" alt="Patient" class="img-responsive">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="item-info-title">
                                                        <h4>Priya Singh</h4>
                                                        <p class="testimonial_subtitle">Skin Allergy Patient</p>
                                                    </div>
                                                    <div class="uni-divider"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-caption">
                                            <p>"After years of skin problems, I found relief at Kalpataru. The dermatologist listened to all my concerns and treated me effectively. I'm so grateful."</p>
                                        </div>
                                    </div>
                                    <div class="uni-shortcode-testimonials-default">
                                        <div class="item-info">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="item-info-img">
                                                        <img src="{{ asset('frontend/images/testimonial/img1.png') }}" alt="Patient" class="img-responsive">
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="item-info-title">
                                                        <h4>Amit Patel</h4>
                                                        <p class="testimonial_subtitle">Cancer Survivor</p>
                                                    </div>
                                                    <div class="uni-divider"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-caption">
                                            <p>"The oncology team treated me with compassion and the latest medical advancements. Their support during my treatment gave me strength. A truly world-class facility."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OPENING HOURS (from settings or real default) -->
                <div class="col-md-4">
                    <div class="uni-services-opinging-hours">
                        <div class="uni-services-opinging-hours-title">
                            <div class="icon">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                            </div>
                            <h4>Opening Hours</h4>
                        </div>
                        <div class="uni-services-opinging-hours-content">
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

    <!-- ============================= -->
    <!-- MAP -->
    <!-- ============================= -->
    <div class="uni-about-map">
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1374128.6632203332!2d76.60741978323914!3d24.353861386838968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397957006b0dced1%3A0x1c398043e2b9eb18!2sKalpataru%20Multispeciality%20Hospital%20Ganjbasoda!5e1!3m2!1sen!2sin!4v1782983253504!5m2!1sen!2sin" height="700" style="border:0" allowfullscreen loading="lazy"></iframe>
    </div>
</div>
@endsection