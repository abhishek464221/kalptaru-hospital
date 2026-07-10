<!-- Mobile Nav -->
<nav class="visible-sm visible-xs mobile-menu-container mobile-nav">
    <div class="menu-mobile-nav navbar-toggle">
        <span class="icon-bar"><i class="fa fa-bars" aria-hidden="true"></i></span>
    </div>
    <div id="cssmenu" class="animated">
        <div class="uni-icons-close"><i class="fa fa-times" aria-hidden="true"></i></div>
        <ul class="nav navbar-nav animated">
            <li class="has-sub"><a href="{{ url('/') }}">Home</a></li>
            <li class="has-sub"><a href="{{ url('/about') }}">About</a></li>
            <li class="has-sub"><a href="{{ url('/doctors') }}">Doctors</a></li>
            <li class="has-sub"><a href="{{ url('/services') }}">Services</a></li>
            <li class="has-sub"><a href="{{ url('/blog') }}">Blog</a></li>
            <li class="has-sub"><a href="{{ url('/contact') }}">Contact</a></li>
        </ul>
        <div class="clearfix"></div>
    </div>
</nav>

<!-- Desktop Header -->
<header>
    <div class="uni-medicare-header sticky-menu">
        <div class="container">
            <div class="uni-medicare-header-main">
                <div class="row">
                    <div class="col-md-2">
                        <div class="wrapper-logo">
                            <a class="logo-default" href="{{ url('/') }}">
                                @php
                                    $headerLogo = $settings['logo_header'] ?? 'frontend/images/logo.png';
                                    $logoPath = (!empty($headerLogo) && Storage::disk('public')->exists($headerLogo)) 
                                        ? asset('storage/' . $headerLogo) 
                                        : asset('frontend/images/logo.png');
                                @endphp
                                <img src="{{ $logoPath }}" alt="{{ $settings['company_name'] ?? 'Medicare Plus' }}" class="img-responsive">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="uni-main-menu">
                            <nav class="main-navigation uni-menu-text">
                                <div class="cssmenu">
                                    <ul>
                                        <li class="has-sub"><a href="{{ url('/') }}">Home</a></li>
                                        <li class="has-sub"><a href="{{ url('/about') }}">About</a></li>
                                        <li class="has-sub"><a href="{{ url('/doctors') }}">Doctors</a></li>
                                        <li class="has-sub"><a href="{{ url('/services') }}">Services</a></li>
                                        <li class="has-sub"><a href="{{ url('/blog') }}">Blog</a></li>
                                        <li class="has-sub"><a href="{{ url('/gallery') }}">Gallery</a></li>
                                        <li class="has-sub"><a href="{{ url('/contact') }}">Contact</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="uni-search-appointment">
                            <ul>
                                <li class="un-btn-search"><i class="fa fa-search"></i></li>
                                <li class="uni-btn-appointment">
                                    <a href="#" data-toggle="modal" data-target="#appointmentModal">
                                        Appointment
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Shortcode mega menu -->
                <div class="show-hover-shortcodes animated">
                    <div class="short-code-title">
                        <div class="row">
                            <div class="col-md-3"><h4>SHORT CODE 1</h4></div>
                            <div class="col-md-3"><h4>SHORT CODE 2</h4></div>
                            <div class="col-md-3"><h4>SHORT CODE 3</h4></div>
                            <div class="col-md-3"><h4>SHORT CODE 4</h4></div>
                        </div>
                    </div>
                    <div class="short-code-content">
                        <div class="row">
                            <div class="col-md-3">
                                <ul>
                                    <li><a href="{{ url('buttons') }}"><i class="fa fa-plus-square"></i>Buttons</a></li>
                                    <li><a href="{{ url('icons-box') }}"><i class="fa fa-cube"></i>Icon Box</a></li>
                                    <li><a href="{{ url('progress') }}"><i class="fa fa-tasks"></i>Process Bar</a></li>
                                    <li><a href="{{ url('tabs') }}"><i class="fa fa-columns"></i>Tabs</a></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul>
                                    <li><a href="{{ url('accordion') }}"><i class="fa fa-list"></i>Accordion</a></li>
                                    <li><a href="{{ url('counter') }}"><i class="fa fa-tachometer"></i>Counter</a></li>
                                    <li><a href="{{ url('testimonials') }}"><i class="fa fa-comments-o"></i>Testimonials</a></li>
                                    <li><a href="{{ url('typography') }}"><i class="fa fa-text-width"></i>Typography</a></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul>
                                    <li><a href="{{ url('partner') }}"><i class="fa fa-handshake-o"></i>Partner</a></li>
                                    <li><a href="{{ url('team') }}"><i class="fa fa-users"></i>Team</a></li>
                                    <li><a href="{{ url('item-list') }}"><i class="fa fa-list-ol"></i>Item List</a></li>
                                    <li><a href="{{ url('divider') }}"><i class="fa fa-chain-broken"></i>Dividers</a></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <ul>
                                    <li><a href="{{ url('columns') }}"><i class="fa fa-bar-chart"></i>Columns</a></li>
                                    <li><a href="{{ url('pricing-table') }}"><i class="fa fa-address-card-o"></i>Pricing table</a></li>
                                    <li><a href="{{ url('404') }}"><i class="fa fa-exclamation-triangle"></i>404 Pages</a></li>
                                    <li><a href="{{ url('comming-soon') }}"><i class="fa fa-repeat"></i>Comming soon</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search form -->
                <div class="uni-form-search-header">
                    <div class="box-search-header collapse" id="box-search-header">
                        <div class="uni-input-group">
                            <input type="text" name="key" placeholder="Search" class="form-control">
                            <button class="uni-btn btn-search"><i class="fa fa-long-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>