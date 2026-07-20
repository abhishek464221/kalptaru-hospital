<footer class="site-footer footer-default">
    <div class="footer-main-content">
        <div class="container">
            <div class="row">
                <div class="footer-main-content-elements">
                    <!-- ===== COLUMN 1: Logo & Company Info ===== -->
                    <div class="footer-main-content-element col-md-3 col-sm-6">
                        <aside class="widget">
                            <div class="widget-title uni-uppercase">
                                <a href="{{ url('/') }}">
                                    @php
                                        $footerLogo = $settings['logo_footer'] ?? 'images/logowhite.png';
                                        $footerLogoPath = (!empty($footerLogo) && file_exists(public_path('storage/' . $footerLogo)))
                                            ? asset('storage/' . $footerLogo)
                                            : asset('frontend/images/logowhite.png');
                                    @endphp
                                    <img src="{{ $footerLogoPath }}" alt="{{ $settings['company_name'] ?? 'Medicare Plus' }}" class="img-responsive">
                                </a>
                            </div>
                            <div class="widget-content">
                                <p>{{ $settings['company_description'] ?? 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget.' }}</p>
                                <div class="uni-info-contact">
                                    <ul>
                                        <li><i class="fa fa-map-marker"></i> {{ $settings['address'] ?? '45 Queen\'s Park Rd, Brighton, UK' }}</li>
                                        <li><i class="fa fa-phone"></i> {{ $settings['phone'] ?? '(094) 123 4567' }}</li>
                                        <li><i class="fa fa-envelope-o"></i> {{ $settings['email'] ?? 'medicareplus@domain.com' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>

                    <!-- ===== COLUMN 2: Quick Links ===== -->
                    <div class="footer-main-content-element col-md-3 col-sm-6">
                        <aside class="widget">
                            <h3 class="widget-title uni-uppercase">quick links</h3>
                            <div class="widget-content">
                                <div class="uni-quick-link">
                                    <ul>
                                        <li><a href="{{ url('/') }}"><span>+</span> Home</a></li>
                                        <li><a href="{{ url('about') }}"><span>+</span> About</a></li>
                                        <li><a href="{{ url('services') }}"><span>+</span> Services</a></li>
                                        <li><a href="{{ url('doctors') }}"><span>+</span> Doctors</a></li>
                                        <li><a href="{{ url('blog') }}"><span>+</span> Blog</a></li>
                                        <li><a href="{{ url('contact') }}"><span>+</span> Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>

                    <!-- ===== COLUMN 3: Latest Posts ===== -->
                    <div class="footer-main-content-element col-md-3 col-sm-6">
                        <aside class="widget">
                            <h3 class="widget-title uni-uppercase">latest posts</h3>
                            <div class="widget-content">
                                <div class="uni-footer-latest-post">
                                    <ul>
                                        @php
                                            $footerLatestPosts = App\Models\Blog::published()
                                                ->orderBy('published_at', 'desc')
                                                ->orderBy('created_at', 'desc')
                                                ->limit(4)
                                                ->get();
                                        @endphp
                                        @forelse($footerLatestPosts as $post)
                                        <li>
                                            <h4><a href="{{ route('frontend.blog.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a></h4>
                                            <span class="time">{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                                        </li>
                                        @empty
                                        <li>
                                            <h4><a href="#">No posts yet</a></h4>
                                            <span class="time">Coming soon</span>
                                        </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>

                    <!-- ===== COLUMN 4: Newsletter & Social ===== -->
                    <div class="footer-main-content-element col-md-3 col-sm-6">
                        <aside class="widget">
                            <h3 class="widget-title uni-uppercase">News<span>letter</span></h3>
                            <div class="widget-content">
                                <div class="uni-footer-newletter">
                                    <!-- Subscribe Form -->
                                    <form id="subscribeForm" action="{{ route('frontend.subscriber.store') }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="email" 
                                                class="form-control" 
                                                name="email" 
                                                id="subscribeEmail" 
                                                placeholder="Enter your email" 
                                                required>
                                            <button class="btn btn-sub" type="submit" id="subscribeMessage">
                                                Subscribe
                                            </button>
                                        </div>
                                        <div id="subscribeMessage" class="mt-2"></div>
                                    </form>

                                    <div class="uni-social">
                                        <h4>Follow us</h4>
                                        <ul>
                                            @if($settings['facebook_url'] ?? false)
                                                <li><a href="{{ $settings['facebook_url'] }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                            @endif
                                            @if($settings['twitter_url'] ?? false)
                                                <li><a href="{{ $settings['twitter_url'] }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                            @endif
                                            @if($settings['instagram_url'] ?? false)
                                                <li><a href="{{ $settings['instagram_url'] }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                            @endif
                                            @if($settings['linkedin_url'] ?? false)
                                                <li><a href="{{ $settings['linkedin_url'] }}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                            @endif
                                            @if(!($settings['facebook_url'] ?? false) && !($settings['twitter_url'] ?? false) && !($settings['instagram_url'] ?? false) && !($settings['linkedin_url'] ?? false))
                                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                                <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Copyright Area ===== -->
    <div class="copyright-area">
        <div class="container">
            <div class="copyright-content">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="copyright-text">
                            &copy; {{ date('Y') }}
                            {{ $settings['company_name'] ?? 'Medicare Plus' }}.
                            All rights reserved.
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <ul class="copyright-menu">
                            <li><a href="#">Term Of Use</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@push('scripts')
<script>
$(document).ready(function() {
    $('#subscribeForm').on('submit', function(e) {
        e.preventDefault();

        let email = $('#subscribeEmail').val();
        let btn = $('#subscribeBtn');
        let msg = $('#subscribeMessage');

        btn.prop('disabled', true).html('Subscribing...');
        msg.html('');

        $.ajax({
            url: '{{ route("frontend.subscriber.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: email
            },
            success: function(response) {
                if (response.success) {
                    msg.html('<div class="alert alert-success">✅ ' + response.message + '</div>');
                    $('#subscribeEmail').val('');
                } else {
                    msg.html('<div class="alert alert-danger">❌ ' + response.message + '</div>');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors && errors.email) {
                    msg.html('<div class="alert alert-danger">❌ ' + errors.email[0] + '</div>');
                } else {
                    msg.html('<div class="alert alert-danger">❌ Something went wrong.</div>');
                }
            },
            complete: function() {
                btn.prop('disabled', false).html('Subscribe');
            }
        });
    });
});
</script>
@endpush