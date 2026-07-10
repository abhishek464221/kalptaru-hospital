@extends('frontend.layouts.app')

@section('title', 'Services - ' . ($settings['company_name'] ?? 'Medicare Plus'))

@section('content')
    <!-- Banner -->
    <div class="uni-banner-default uni-background-1">
        <div class="container">
            <div class="page-title">
                <div class="page-title-inner">
                    <h1>Our Services</h1>
                </div>
            </div>
            <ul class="breadcrumbs">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="#">Services</a></li>
            </ul>
        </div>
    </div>

    <div class="uni-services-body">

        <!-- ========================================= -->
        <!-- OUR SERVICES 1 – 6 CARDS WITH READ MORE   -->
        <!-- ========================================= -->
        <div class="uni-our-services-1">
            <div class="container">
                <div class="uni-services-title">
                    <h3>Our Services</h3>
                    <div class="uni-underline"></div>
                </div>
            </div>
            <div class="uni-shortcode-icons-box-5">
                <div class="container">
                    <div class="row services-row">
                        @php
                            $services = [
                                [
                                    'icon' => 'icon-5.png',
                                    'title' => 'Cardiology & Heart Care',
                                    'short_desc' => 'Advanced diagnosis and treatment for heart diseases, including angioplasty, bypass surgery, and cardiac rehabilitation.',
                                    'long_desc' => 'Our Cardiology department provides comprehensive cardiac care including diagnostic tests (ECG, echo, stress test), interventional procedures (angioplasty, stent placement), and surgical interventions (bypass surgery, valve replacement). We also offer post-surgical rehabilitation and lifestyle management programs to ensure long-term heart health.'
                                ],
                                [
                                    'icon' => 'icon-4.png',
                                    'title' => 'Orthopedics & Joint Replacement',
                                    'short_desc' => 'Comprehensive care for bone, joint, and spine disorders – from fracture management to knee/hip replacement surgeries.',
                                    'long_desc' => 'Our Orthopedics team specializes in treating musculoskeletal conditions. We offer advanced surgical options like total knee replacement, hip replacement, arthroscopy, and spinal fusion. Non-surgical treatments include physiotherapy, pain management, and customized orthotic support to restore mobility and quality of life.'
                                ],
                                [
                                    'icon' => 'icon-3.png',
                                    'title' => 'General Medicine & Wellness',
                                    'short_desc' => 'Routine health check-ups, preventive care, and management of chronic conditions like diabetes, hypertension, and thyroid.',
                                    'long_desc' => 'Our General Medicine department provides holistic healthcare for adults. We manage acute illnesses, chronic diseases (diabetes, hypertension, asthma), and offer preventive health packages. Our experienced physicians work closely with specialists for coordinated care.'
                                ],
                                [
                                    'icon' => 'icon-2.png',
                                    'title' => 'Oncology & Cancer Care',
                                    'short_desc' => 'Multi-disciplinary cancer treatment including chemotherapy, radiation, immunotherapy, and palliative support.',
                                    'long_desc' => 'Our Cancer Care Centre offers comprehensive oncology services – medical oncology (chemotherapy, targeted therapy), radiation oncology, and surgical oncology. Our multi-disciplinary tumor board creates personalized treatment plans. We also provide nutritional counseling, psychological support, and palliative care.'
                                ],
                                [
                                    'icon' => 'icon-1.png',
                                    'title' => 'Pulmonology & Respiratory Care',
                                    'short_desc' => 'Treatment for asthma, COPD, pneumonia, and sleep apnea with state-of-the-art pulmonary function testing.',
                                    'long_desc' => 'Our Pulmonology department diagnoses and treats respiratory disorders using advanced techniques like pulmonary function tests, bronchoscopy, and sleep studies. We manage asthma, COPD, pneumonia, tuberculosis, and interstitial lung diseases, and offer smoking cessation programs.'
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
                            <div class="col-md-4 col-sm-6 service-col">
                                <div class="uni-shortcode-icons-box-5-default">
                                    <div class="item-icons-title">
                                        <div class="col-md-4 uni-clear-padding">
                                            <div class="item-icons">
                                                <img src="{{ asset('frontend/images/icons_box/icon_4/'.$service['icon']) }}" alt="{{ $service['title'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-8 uni-clear-padding">
                                            <div class="item-title">
                                                <h4>{{ $service['title'] }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-caption">
                                        <p>{{ $service['short_desc'] }}</p>
                                        <a href="#" class="readmore"
                                           data-title="{{ $service['title'] }}"
                                           data-description="{{ $service['long_desc'] }}"
                                           data-icon="{{ asset('frontend/images/icons_box/icon_4/'.$service['icon']) }}"
                                           data-toggle="modal" data-target="#serviceModal">
                                            Read more
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================= -->
        <!-- OUR SERVICES 2 – TABS WITH DETAILS        -->
        <!-- ========================================= -->
        <div class="uni-our-services-2 uni-background-4">
            <div class="container">
                <div class="uni-services-title">
                    <h3>Specialized Treatments</h3>
                    <div class="uni-underline"></div>
                </div>

                <div class="uni-our-service-2-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="tab-nav">
                                <ul class="nav-pills nav-stacked">
                                    <li class="active"><a href="#tab_a" data-toggle="pill">Cardiothoracic Surgery</a></li>
                                    <li><a href="#tab_b" data-toggle="pill">Corneal Transplant</a></li>
                                    <li><a href="#tab_c" data-toggle="pill">General Health Check</a></li>
                                    <li><a href="#tab_d" data-toggle="pill">Cancer Diagnosis & Treatment</a></li>
                                    <li><a href="#tab_e" data-toggle="pill">Dermatitis Treatment</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">
                                <!-- TAB A -->
                                <div class="tab-pane active" id="tab_a">
                                    <div class="uni-our-service-2-content-default">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="item-img">
                                                    <img src="{{ asset('frontend/images/services/img.jpg') }}" alt="Cardiothoracic Surgery" class="img-responsive">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="item-caption">
                                                    <div class="item-caption-title">
                                                        <h3>Cardiothoracic Surgery</h3>
                                                        <div class="uni-line"></div>
                                                    </div>
                                                    <p>Our cardiothoracic surgery department specializes in surgical treatment of heart, lungs, and other thoracic organs. We perform coronary artery bypass grafting (CABG), valve repair/replacement, lung resections, and minimally invasive cardiac surgeries. Our team ensures comprehensive pre- and post-operative care for the best outcomes.</p>
                                                    <ul>
                                                        <li>Coronary artery bypass surgery</li>
                                                        <li>Heart valve repair & replacement</li>
                                                        <li>Lung cancer surgery (lobectomy, pneumonectomy)</li>
                                                        <li>Minimally invasive cardiac surgery (MICS)</li>
                                                        <li>Post-surgical cardiac rehabilitation</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB B -->
                                <div class="tab-pane" id="tab_b">
                                    <div class="uni-our-service-2-content-default">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="item-img">
                                                    <img src="{{ asset('frontend/images/services/img1.jpg') }}" alt="Corneal Transplant" class="img-responsive">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="item-caption">
                                                    <div class="item-caption-title">
                                                        <h3>Corneal Transplant Surgery</h3>
                                                        <div class="uni-line"></div>
                                                    </div>
                                                    <p>Our ophthalmology team performs corneal transplantation (keratoplasty) to restore vision in patients with corneal damage. We offer penetrating keratoplasty (full-thickness), lamellar keratoplasty (partial), and endothelial keratoplasty. We use the latest techniques and ensure proper donor tissue matching.</p>
                                                    <ul>
                                                        <li>Penetrating keratoplasty</li>
                                                        <li>Lamellar keratoplasty (DALK, DSEK, DMEK)</li>
                                                        <li>Corneal collagen cross-linking</li>
                                                        <li>Treatment of corneal infections & ulcers</li>
                                                        <li>Post-transplant care & follow-up</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB C -->
                                <div class="tab-pane" id="tab_c">
                                    <div class="uni-our-service-2-content-default">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="item-img">
                                                    <img src="{{ asset('frontend/images/services/img2.jpg') }}" alt="Health Check" class="img-responsive">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="item-caption">
                                                    <div class="item-caption-title">
                                                        <h3>General Health Check</h3>
                                                        <div class="uni-line"></div>
                                                    </div>
                                                    <p>Our comprehensive health check-up packages are designed for early detection and prevention of diseases. We offer executive health check-ups, cardiac risk assessment, diabetes screening, and women's health packages. All tests are performed using modern equipment, and results are reviewed by experienced physicians.</p>
                                                    <ul>
                                                        <li>Complete blood count & biochemistry</li>
                                                        <li>Cardiac risk profile (lipid, ECG, stress test)</li>
                                                        <li>Diabetes screening & management</li>
                                                        <li>Cancer screening (pap smear, mammography, PSA)</li>
                                                        <li>Personalized lifestyle advice</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB D -->
                                <div class="tab-pane" id="tab_d">
                                    <div class="uni-our-service-2-content-default">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="item-img">
                                                    <img src="{{ asset('frontend/images/services/img3.jpg') }}" alt="Cancer Care" class="img-responsive">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="item-caption">
                                                    <div class="item-caption-title">
                                                        <h3>Cancer Diagnosis & Treatment</h3>
                                                        <div class="uni-line"></div>
                                                    </div>
                                                    <p>Our oncology department provides comprehensive cancer care including early diagnosis, surgical oncology, chemotherapy, radiation therapy, and palliative care. We follow international treatment protocols and have a dedicated tumor board to review each case. We also provide emotional and nutritional support to patients and families.</p>
                                                    <ul>
                                                        <li>Cancer screening & early detection</li>
                                                        <li>Medical oncology (chemotherapy, immunotherapy)</li>
                                                        <li>Radiation oncology (external beam, brachytherapy)</li>
                                                        <li>Surgical oncology (tumor resection)</li>
                                                        <li>Palliative & supportive care</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB E -->
                                <div class="tab-pane" id="tab_e">
                                    <div class="uni-our-service-2-content-default">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="item-img">
                                                    <img src="{{ asset('frontend/images/services/img3.jpg') }}" alt="Dermatitis" class="img-responsive">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="item-caption">
                                                    <div class="item-caption-title">
                                                        <h3>Treatment of Dermatitis</h3>
                                                        <div class="uni-line"></div>
                                                    </div>
                                                    <p>Our dermatology clinic offers advanced treatment for all types of dermatitis – atopic, contact, seborrheic, and stasis dermatitis. We use a combination of topical therapies, phototherapy, oral medications, and lifestyle modifications. We also provide allergy testing to identify triggers and prevent recurrence.</p>
                                                    <ul>
                                                        <li>Topical corticosteroids & calcineurin inhibitors</li>
                                                        <li>Phototherapy (UVB, PUVA)</li>
                                                        <li>Oral immunosuppressants & antihistamines</li>
                                                        <li>Patch testing for contact dermatitis</li>
                                                        <li>Skin care guidance & prevention</li>
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

        <!-- ========================================= -->
        <!-- DEPARTMENTS, TESTIMONIALS, OPENING HOURS  -->
        <!-- ========================================= -->
        <div class="uni-services-de-test-hours">
            <div class="container">
                <div class="row">

                    <!-- DEPARTMENTS -->
                    <div class="col-md-4">
                        <div class="uni-services-department">
                            <div class="uni-services-title">
                                <h3>Departments</h3>
                                <div class="uni-line"></div>
                            </div>
                            <div class="uni-services-department-content">
                                <div class="accordion-default">
                                    <div class="accordion-icons-img">
                                        <div class="accordion">
                                            @php
                                                $depts = [
                                                    ['icon' => 'icon-5.png', 'name' => 'Cardiology', 'desc' => 'Comprehensive heart care including diagnostics, angioplasty, and cardiac surgery.'],
                                                    ['icon' => 'icon-4.png', 'name' => 'Neurology', 'desc' => 'Diagnosis and treatment of brain, spine, and nervous system disorders.'],
                                                    ['icon' => 'icon-3.png', 'name' => 'Orthopedics', 'desc' => 'Bone, joint, and spine treatments including joint replacement and fracture care.'],
                                                    ['icon' => 'icon-2.png', 'name' => 'Cancer Department', 'desc' => 'Multi-disciplinary oncology care – chemotherapy, radiation, and surgery.'],
                                                    ['icon' => 'icon-1.png', 'name' => 'Ophthalmology', 'desc' => 'Eye care services including cataract, glaucoma, and corneal transplant.'],
                                                    ['icon' => 'icon.png', 'name' => 'Respiratory', 'desc' => 'Treatment of asthma, COPD, pneumonia, and sleep disorders.']
                                                ];
                                            @endphp
                                            @foreach($depts as $index => $dept)
                                                <div class="accordion-item">
                                                    <div class="accordion-toggle {{ $index == 0 ? 'active' : '' }}">
                                                        <div class="accordion-icosn">
                                                            <img src="{{ asset('frontend/images/icons_box/icon_1/'.$dept['icon']) }}" alt="{{ $dept['name'] }}">
                                                        </div>
                                                        <h4>{{ $dept['name'] }}</h4>
                                                    </div>
                                                    <div class="accordion-content" style="{{ $index == 0 ? 'display: block;' : 'display: none;' }}">
                                                        <p>{{ $dept['desc'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TESTIMONIALS -->
                    <div class="col-md-4">
                        <div class="uni-services-testimonials">
                            <div class="uni-services-title">
                                <h3>Testimonials</h3>
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
                                                            <p class="testimonial_subtitle">Cardiac Patient</p>
                                                        </div>
                                                        <div class="uni-divider"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-caption">
                                                <p>"The heart surgery was a life-changing experience. The doctors and staff were incredibly supportive throughout my recovery. I am grateful for their expertise."</p>
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
                                                            <p class="testimonial_subtitle">Knee Replacement</p>
                                                        </div>
                                                        <div class="uni-divider"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-caption">
                                                <p>"I can finally walk without pain! The orthopedic team gave me a new lease on life. Highly recommend this hospital."</p>
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
                                                            <h4>Amit Patel</h4>
                                                            <p class="testimonial_subtitle">Cancer Survivor</p>
                                                        </div>
                                                        <div class="uni-divider"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-caption">
                                                <p>"The oncology department is world-class. They treated me with compassion and the latest medical advancements. I am cancer-free today!"</p>
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
                                                            <h4>Priya Singh</h4>
                                                            <p class="testimonial_subtitle">Skin Allergy</p>
                                                        </div>
                                                        <div class="uni-divider"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-caption">
                                                <p>"After years of skin problems, I finally found relief here. The dermatologist was thorough and caring."</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OPENING HOURS -->
                    <div class="col-md-4">
                        <div class="uni-services-opinging-hours">
                            <div class="uni-services-opinging-hours-title">
                                <div class="icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                                <h4>Opening Hours</h4>
                            </div>
                            <div class="uni-services-opinging-hours-content">
                                <table class="table">
                                    <tr><td>Monday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>Tuesday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>Wednesday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>Thursday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>Friday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>Saturday</td><td>8:00 - 17:00</td></tr>
                                    <tr><td>Sunday</td><td>Closed (Emergency only)</td></tr>
                                </table>
                                <a href="#" data-toggle="modal" data-target="#appointmentModal" class="book-appointment">Book Appointment</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- ========================================= -->
    <!-- MODAL – Service Details Popup             -->
    <!-- ========================================= -->
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
                    <p id="modalDescription"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="{{ url('/services') }}" class="btn btn-primary">View All Services</a>
                </div>
            </div>
        </div>
    </div>

@endsection

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