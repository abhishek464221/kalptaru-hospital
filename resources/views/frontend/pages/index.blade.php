@extends('frontend.layouts.app')

@section('title', 'Home - Medicare Plus')

@section('content')
    <!-- Banner Slider -->
    <div class="uni-banner">
        <div class="uni-owl-one-item owl-carousel owl-theme">
            <div class="item">
                <div class="uni-banner-img uni-background-5"></div>
                <div class="content animated" data-animation="flipInX" data-delay="0.9s">
                    <div class="container">
                        <div class="caption">
                            <h1>Let us protect your health</h1>
                            <p>Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.<br>Donec eu libero sit amet quam egestas semper.</p>
                            <a href="#">our services</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="uni-banner-img uni-background-6"></div>
                <div class="content animated" data-animation="flipInX" data-delay="0.9s">
                    <div class="container">
                        <div class="caption">
                            <h1>Let us protect your health</h1>
                            <p>Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.<br>Donec eu libero sit amet quam egestas semper.</p>
                            <a href="#">our services</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="uni-banner-img uni-background-7"></div>
                <div class="content animated" data-animation="flipInX" data-delay="0.9s">
                    <div class="container">
                        <div class="caption">
                            <h1>Let us protect your health</h1>
                            <p>Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.<br>Donec eu libero sit amet quam egestas semper.</p>
                            <a href="#">our services</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Opening Hours & Appointment -->
    <div class="uni-home-opening-book">
        <div class="container">
            <div class="uni-home-opening-book-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="uni-services-opinging-hours">
                            <div class="uni-services-opinging-hours-title">
                                <div class="icon"><i class="fa fa-clock-o"></i></div>
                                <h4>opening hours</h4>
                            </div>
                            <div class="uni-services-opinging-hours-content">
                                <table class="table">
                                    <tr><td>monday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>tuesday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>wednesday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>thursday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>friday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>sunday</td><td>8:00 - 17:00</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="uni-single-department-appointment-form">
                            <div class="uni-home-title">
                                <h3>Book appointment</h3>
                                <div class="uni-underline"></div>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                                </div>
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('frontend.appointment.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input type="text" class="form-control" name="name" placeholder="your name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                            <input type="tel" class="form-control" name="phone" placeholder="phone number" value="{{ old('phone') }}" required>
                                        </div>
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input type="email" class="form-control" name="email" placeholder="email" value="{{ old('email') }}">
                                        </div>
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            <input type="date" class="form-control" name="appointment_date" value="{{ old('appointment_date') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group form-group">
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                            <input type="time" class="form-control" name="appointment_time" value="{{ old('appointment_time') }}" required>
                                        </div>
                                        <div class="input-group form-group">
                                            <textarea name="note" class="form-control" placeholder="additional notes / reason">{{ old('note') }}</textarea>
                                        </div>
                                        <button type="submit" class="vk-btn vk-btn-send">Book Appointment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Departments -->
    <div class="uni-hơm-1-department">
        <div class="container">
            <div class="uni-home-title">
                <h3>Department</h3>
                <div class="uni-underline"></div>
            </div>
            <div class="uni-shortcode-icon-box-1">
                <div class="row">
                    @forelse($departments as $dept)
                        <div class="col-md-4 col-sm-6">
                            <div class="uni-shortcode-icon-box-1-default">
                                <div class="item-icons">
                                    @php
                                        $iconMap = [
                                            'cardiology' => 'fa-heartbeat',
                                            'neurology' => 'fa-cogs',
                                            'orthopedics' => 'fa-medkit',
                                            'pediatrics' => 'fa-child',
                                            'obstetrics & gynecology' => 'fa-female',
                                            'gynecology' => 'fa-female',
                                            'dermatology' => 'fa-star',
                                            'ent' => 'fa-user-md',
                                            'oncology' => 'fa-hospital-o',
                                            'ophthalmology' => 'fa-eye',
                                            'emergency medicine' => 'fa-ambulance',
                                            'radiology' => 'fa-file-image-o',
                                            'pathology' => 'fa-flask',
                                            'anesthesiology' => 'fa-medkit',
                                            'urology' => 'fa-tint',
                                            'psychiatry' => 'fa-smile-o',
                                        ];
                                        $icon = $iconMap[strtolower($dept->name)] ?? 'fa-stethoscope';
                                    @endphp
                                    <i class="fa {{ $icon }}"></i>
                                </div>
                                <div class="item-caption">
                                    <h4>{{ $dept->name }}</h4>
                                    <p>{{ Str::limit($dept->description ?? 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas adipisicing.', 100) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">No departments available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Our Doctors -->
    <div class="uni-home-1-our-doctor">
        <div class="uni-shortcode-team-2 uni-background-2">
            <div class="container">
                <div class="uni-home-title">
                    <h3>Our Doctor</h3>
                    <div class="uni-underline"></div>
                </div>
                <div class="uni-owl-four-item owl-carousel owl-theme">
                    @forelse($homeDoctors as $doctor)
                        <div class="item">
                            <div class="uni-team-default">
                                <div class="item-img">
                                    <img src="{{ $doctor->image }}" alt="{{ $doctor->full_name }}" class="img-responsive">
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
                                            <span>{{ $doctor->specialization }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="item">
                            <p>No doctors available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- OUR SERVICES – UPDATED WITH READ MORE MODAL -->
    <!-- ========================================== -->
    <div class="uni-home-our-services">
        <div class="uni-shortcode-icons-box-5">
            <div class="container">
                <div class="uni-home-title">
                    <h3>Our Services</h3>
                    <div class="uni-underline"></div>
                </div>

                {{-- Bootstrap Grid Row --}}
                <div class="row" style="display: flex; flex-wrap: wrap;">
                    @php
                        $services = [
                            [
                                'icon' => 'icon-5.png',
                                'title' => 'Cardiology & Heart Care',
                                'short_desc' => 'Advanced diagnosis and treatment for heart diseases, including angioplasty, bypass surgery, and cardiac rehabilitation.',
                                'long_desc' => 'Our Cardiology department offers comprehensive cardiac care including diagnostic tests (ECG, echo, stress test), interventional procedures (angioplasty, stent placement), and surgical interventions (bypass surgery, valve replacement). We also provide post-surgical rehabilitation and lifestyle management programs to ensure long-term heart health.'
                            ],
                            [
                                'icon' => 'icon-4.png',
                                'title' => 'Orthopedics & Joint Replacement',
                                'short_desc' => 'Comprehensive care for bone, joint, and spine disorders – from fracture management to knee/hip replacement surgeries.',
                                'long_desc' => 'Our Orthopedics team specializes in treating musculoskeletal conditions. We offer advanced surgical options like total knee replacement, hip replacement, arthroscopy, and spinal fusion. Non-surgical treatments include physiotherapy, pain management, and customized orthotic support. We are committed to restoring your mobility and quality of life.'
                            ],
                            [
                                'icon' => 'icon-3.png',
                                'title' => 'General Medicine & Wellness',
                                'short_desc' => 'Routine health check-ups, preventive care, and management of chronic conditions like diabetes, hypertension, and thyroid.',
                                'long_desc' => 'Our General Medicine department provides holistic healthcare for adults. We manage acute illnesses, chronic diseases (diabetes, hypertension, asthma), and offer preventive health packages. Our team of experienced physicians works closely with specialists to ensure coordinated care for complex conditions.'
                            ],
                            [
                                'icon' => 'icon-2.png',
                                'title' => 'Oncology & Cancer Care',
                                'short_desc' => 'Multi-disciplinary cancer treatment including chemotherapy, radiation, immunotherapy, and palliative support.',
                                'long_desc' => 'Our Cancer Care Centre provides comprehensive oncology services. We offer medical oncology (chemotherapy, targeted therapy), radiation oncology, and surgical oncology. Our multi-disciplinary tumor board discusses each case to create personalized treatment plans. We also provide nutritional counseling, psychological support, and palliative care for holistic patient well-being.'
                            ],
                            [
                                'icon' => 'icon-1.png',
                                'title' => 'Pulmonology & Respiratory Care',
                                'short_desc' => 'Treatment for asthma, COPD, pneumonia, and sleep apnea with state-of-the-art pulmonary function testing.',
                                'long_desc' => 'Our Pulmonology department diagnoses and treats respiratory disorders using advanced techniques like pulmonary function tests, bronchoscopy, and sleep studies. We manage conditions such as asthma, COPD, pneumonia, tuberculosis, and interstitial lung diseases. We also offer smoking cessation programs and respiratory rehabilitation.'
                            ],
                            [
                                'icon' => 'icon.png',
                                'title' => 'Dermatology & Skin Care',
                                'short_desc' => 'Expert care for skin diseases, allergies, acne, psoriasis, and cosmetic dermatology procedures.',
                                'long_desc' => 'Our Dermatology clinic provides medical and cosmetic dermatology services. We treat skin infections, eczema, psoriasis, acne, vitiligo, and hair disorders. Cosmetic procedures include laser therapy, chemical peels, and anti-aging treatments. We also perform skin cancer screenings and mole evaluations.'
                            ]
                        ];
                    @endphp

                    @foreach($services as $service)
                        <div class="col-md-4 col-sm-6" >
                            <div class="uni-shortcode-icons-box-5-default">
                                <div class="item-icons-title" >
                                    <div class="item-icons" >
                                        <img src="{{ asset('frontend/images/icons_box/icon_4/'.$service['icon']) }}" alt="{{ $service['title'] }}" style="max-width: 40px; max-height: 40px;">
                                    </div>
                                    <div class="item-title">
                                        <h4>{{ $service['title'] }}</h4>
                                    </div>
                                </div>
                                <div class="item-caption">
                                    <p>{{ $service['short_desc'] }}</p>
                                    <a href="#" class="readmore" 
                                    data-title="{{ $service['title'] }}"
                                    data-description="{{ $service['long_desc'] }}"
                                    data-icon="{{ asset('/frontend/images/icons_box/icon_4/'.$service['icon']) }}"
                                    data-toggle="modal" data-target="#serviceModal">
                                        Read more
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="btn-all-services">
                    <a href="{{ url('/services') }}">
                        All services +
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Customers Say (Testimonials) -->
    <div class="uni-home-customers-says">
        <div class="uni-shortcode-testimonials-2 uni-background-3">
            <div class="container">
                <div class="uni-home-title">
                    <h3>What Our Patients Say</h3>
                    <div class="uni-underline"></div>
                </div>

                <div class="uni-owl-two-item owl-carousel owl-theme">
                    @php
                        $testimonials = [
                            [
                                'img' => 'img.png',
                                'name' => 'Ramesh Gupta',
                                'sub'  => 'Cardiac Patient',
                                'feedback' => 'The heart surgery was a life-changing experience. The doctors and staff were incredibly supportive throughout my recovery.'
                            ],
                            [
                                'img' => 'img1.png',
                                'name' => 'Sunita Sharma',
                                'sub'  => 'Knee Replacement',
                                'feedback' => 'I can finally walk without pain! The orthopedic team gave me a new lease on life. Highly recommend this hospital.'
                            ],
                            [
                                'img' => 'img.png',
                                'name' => 'Amit Patel',
                                'sub'  => 'Cancer Survivor',
                                'feedback' => 'The oncology department is world-class. They treated me with compassion and the latest medical advancements.'
                            ],
                            [
                                'img' => 'img1.png',
                                'name' => 'Priya Singh',
                                'sub'  => 'Skin Allergy',
                                'feedback' => 'After years of skin problems, I finally found relief here. The dermatologist was thorough and caring.'
                            ]
                        ];
                    @endphp

                    @foreach($testimonials as $testimonial)
                        <div class="item">
                            <div class="uni-shortcode-testimonials-default">
                                <div class="item-info">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4">
                                            <div class="item-info-img">
                                                <img src="{{ asset('/frontend/images/testimonial/'.$testimonial['img']) }}" alt="{{ $testimonial['name'] }}" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-md-9 col-sm-8">
                                            <div class="item-info-title">
                                                <h4>{{ $testimonial['name'] }}</h4>
                                                <p class="testimonial_subtitle">{{ $testimonial['sub'] }}</p>
                                            </div>
                                            <div class="uni-divider"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-caption">
                                    <p>{{ $testimonial['feedback'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ & Latest Posts -->
    <div class="uni-home-faq-latest-post">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="uni-home-faq">
                        <div class="uni-home-title">
                            <h3>Frequently Asked Questions</h3>
                            <div class="uni-line"></div>
                        </div>

                        <div class="accordion-default">
                            <div class="accordion-min-plus">
                                <div class="accordion">

                                    @php
                                        $faqs = [
                                            [
                                                'question' => 'How can I book an appointment?',
                                                'answer' => 'You can book an appointment online through our website, call our reception, or visit the hospital directly.'
                                            ],
                                            [
                                                'question' => 'What are the hospital working hours?',
                                                'answer' => 'Our outpatient department (OPD) is open from 9:00 AM to 8:00 PM, Monday to Saturday. Emergency services are available 24/7.'
                                            ],
                                            [
                                                'question' => 'Do you provide emergency services?',
                                                'answer' => 'Yes, we provide 24/7 emergency medical services with experienced doctors and emergency staff.'
                                            ],
                                            [
                                                'question' => 'Can I consult a specialist doctor?',
                                                'answer' => 'Yes, we have experienced specialists in Cardiology, Orthopedics, Neurology, Pediatrics, Gynecology, Dermatology, and many other departments.'
                                            ],
                                            [
                                                'question' => 'Do you accept health insurance?',
                                                'answer' => 'Yes, we accept cashless treatment through many leading health insurance providers. Please contact our help desk for the complete list.'
                                            ],
                                            [
                                                'question' => 'How can I access my medical reports?',
                                                'answer' => 'You can collect your reports from the hospital or access them online if the digital report facility is available.'
                                            ],
                                            [
                                                'question' => 'What payment methods are accepted?',
                                                'answer' => 'We accept Cash, UPI, Debit Cards, Credit Cards, Net Banking, and selected health insurance payments.'
                                            ],
                                            [
                                                'question' => 'Do I need an appointment before visiting?',
                                                'answer' => 'Appointments are recommended to reduce waiting time, but walk-in patients are also welcome depending on doctor availability.'
                                            ],
                                        ];
                                    @endphp

                                    @foreach($faqs as $faq)
                                        <div class="accordion-item">
                                            <h4 class="accordion-toggle">{{ $faq['question'] }}</h4>
                                            <div class="accordion-content">
                                                <p>{{ $faq['answer'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="uni-home-latest-post">
                        <div class="uni-home-title">
                            <h3>latest posts</h3>
                            <div class="uni-line"></div>
                        </div>
                        <div class="uni-home-latest-post-body">
                            @forelse($latestPosts as $post)
                                <div class="item">
                                    <div class="item-img">
                                        <a href="{{ route('frontend.blog.show', $post->slug) }}">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="img-responsive">
                                            @else
                                                <img src="{{ asset('frontend/images/home1/lastestpost/default.png') }}" alt="{{ $post->title }}" class="img-responsive">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="item-caption">
                                        <h4><a href="{{ route('frontend.blog.show', $post->slug) }}">{{ Str::limit($post->title, 60) }}</a></h4>
                                        <span class="time">{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <div class="uni-divider"></div>
                                @endif
                            @empty
                                <div class="item">
                                    <div class="item-caption">
                                        <h4><a href="#">No blog posts available</a></h4>
                                        <span class="time">Coming soon</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Map -->
    <div class="uni-home-map">
        <div class="uni-about-map">
            <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1374128.6632203332!2d76.60741978323914!3d24.353861386838968!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397957006b0dced1%3A0x1c398043e2b9eb18!2sKalpataru%20Multispeciality%20Hospital%20Ganjbasoda!5e1!3m2!1sen!2sin!4v1782983253504!5m2!1sen!2sin" height="700" style="border:0"></iframe>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL – Service Detail Popup               -->
    <!-- ========================================== -->
    <!-- Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="serviceModalLabel">
                        <img id="modalIcon" src="" alt="Service Icon">
                        <span id="modalTitle"></span>
                    </h4>
                </div>
                <div class="modal-body">
                    <p id="modalDescription" style="font-size:16px; line-height:1.8;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="{{ url('/services') }}" class="btn btn-primary">View All Services</a>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- JavaScript for Modal functionality --}}
@push('scripts')
<script>
    $(document).ready(function() {
        $('#serviceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var title = button.data('title');
            var description = button.data('description');
            var icon = button.data('icon');

            var modal = $(this);
            modal.find('#modalTitle').text(title);
            modal.find('#modalDescription').text(description);
            
            var iconImg = modal.find('#modalIcon');
            if (icon && icon.trim() !== '') {
                iconImg.attr('src', icon);
                iconImg.show();
            } else {
                iconImg.hide();
            }
        });
    });
</script>
@endpush