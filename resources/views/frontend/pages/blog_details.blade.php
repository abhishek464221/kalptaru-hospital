@extends('frontend.layouts.app')

@section('title', $blog->title . ' - Kalptaru Hospital')

@section('content')
<div class="uni-banner-default uni-background-1">
    <div class="container">
        <div class="page-title">
            <div class="page-title-inner">
                <h1>{{ $blog->title }}</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('frontend.blog.index') }}">Blog</a></li>
            <li><a href="#">{{ $blog->title }}</a></li>
        </ul>
    </div>
</div>

<div class="uni-single-post-body">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="uni-single-post-left">
                    <div class="page-content">
                        <article class="post-92 post type-post has-post-thumbnail">
                            <div class="content-inner">
                                <div class="uni-entry-top">
                                    @if($blog->featured_image)
                                    <div class="post-formats-wrapper">
                                        <a class="post-image" href="#">
                                            <img src="{{ asset('storage/' . $blog->featured_image) }}" class="attachment-full size-full wp-post-image img-responsive" alt="{{ $blog->title }}">
                                        </a>
                                    </div>
                                    @endif
                                </div>

                                <div class="uni-entry-body">
                                    <div class="uni-entry-time">
                                        <ul>
                                            <li class="year">{{ $blog->published_at ? $blog->published_at->format('Y') : '' }}</li>
                                            <li class="day">{{ $blog->published_at ? $blog->published_at->format('d') : '' }}</li>
                                            <li class="month">{{ $blog->published_at ? $blog->published_at->format('M') : '' }}</li>
                                        </ul>
                                    </div>
                                    <div class="uni-entry-content">
                                        <header class="uni-entry-header">
                                            <h2 class="uni-entry-title">{{ $blog->title }}</h2>
                                        </header>

                                        <div class="uni-entry-meta">
                                            <span class="uni-author">
                                                <a href="#"><i class="fa fa-calendar" aria-hidden="true"></i> {{ $blog->published_at ? $blog->published_at->format('F d, Y') : '' }}</a>
                                            </span>
                                            <span class="uni-comment-total">
                                                <a href="#"><i class="fa fa-user" aria-hidden="true"></i> {{ $blog->author_name }}</a>
                                            </span>
                                            <span class="uni-entry-folder">
                                                <a href="#"><i class="fa fa-comment" aria-hidden="true"></i> 0 comments</a>
                                            </span>
                                            @if($blog->category)
                                            <span class="uni-entry-folder">
                                                <a href="#"><i class="fa fa-folder" aria-hidden="true"></i> {{ $blog->category }}</a>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="uni-entry-description">
                                            {!! $blog->content !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="uni-divider"></div>

                                <div class="uni-entry-tag-share">
                                    <div class="share-click">
                                        <ul class="thim-social-share">
                                            <li> SHARE: </li>
                                            <li class="facebook"><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                            <li class="twitter"><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                            <li class="youtube"><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                    @if($blog->tags && count($blog->tags))
                                    <div class="tag-click">
                                        <ul class="thim-tag">
                                            <li> Tags: </li>
                                            @foreach($blog->tags as $tag)
                                            <li><a href="#">{{ $tag }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </article>

                        <!-- Post Pagination (Previous/Next) -->
                        @if($prevBlog || $nextBlog)
                        <div class="uni-post-pagination">
                            @if($prevBlog)
                            <div class="col-md-6 col-sm-6 col-xs-6 clear-padding">
                                <div class="uni-post-pagination-left">
                                    <a href="{{ route('frontend.blog.show', $prevBlog->slug) }}">PREVIOUS POST</a>
                                    <div class="uni-pagination-latest">
                                        <div class="thumbnail-img">
                                            <a href="{{ route('frontend.blog.show', $prevBlog->slug) }}">
                                                <img src="{{ $prevBlog->featured_image ? asset('storage/' . $prevBlog->featured_image) : asset('images/default.jpg') }}" alt="{{ $prevBlog->title }}" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="rel-post-text">
                                            <h5 class="entry-title">
                                                <a href="{{ route('frontend.blog.show', $prevBlog->slug) }}">{{ $prevBlog->title }}</a>
                                            </h5>
                                            <div class="entry-meta">
                                                <span class="entry-date"><i class="fa fa-calendar" aria-hidden="true"></i>{{ $prevBlog->published_at ? $prevBlog->published_at->format('M d, Y') : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @endif
                            @if($nextBlog)
                            <div class="col-md-6 col-sm-6 col-xs-6 clear-padding">
                                <div class="uni-post-pagination-right">
                                    <a href="{{ route('frontend.blog.show', $nextBlog->slug) }}">NEXT POST</a>
                                    <div class="uni-pagination-latest">
                                        <div class="thumbnail-img">
                                            <a href="{{ route('frontend.blog.show', $nextBlog->slug) }}">
                                                <img src="{{ $nextBlog->featured_image ? asset('storage/' . $nextBlog->featured_image) : asset('images/default.jpg') }}" alt="{{ $nextBlog->title }}" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="rel-post-text">
                                            <h5 class="entry-title">
                                                <a href="{{ route('frontend.blog.show', $nextBlog->slug) }}">{{ $nextBlog->title }}</a>
                                            </h5>
                                            <div class="entry-meta">
                                                <span class="entry-date"><i class="fa fa-calendar" aria-hidden="true"></i>{{ $nextBlog->published_at ? $nextBlog->published_at->format('M d, Y') : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        @endif

                        <!-- Author Box (if author exists) -->
                        @if($blog->author)
                        <div class="uni-author">
                            <div class="uni-author-info">
                                <div class="item-img">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($blog->author->name) }}&size=100&background=random" alt="" class="img-responsive">
                                </div>
                                <div class="item-content">
                                    <span class="author-name">{{ $blog->author->name }}</span>
                                    <p>{{ $blog->author->email ?? '' }}</p>
                                    <!-- You can add bio if you have -->
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Comments Section (Static for now, but you can integrate a comment system later) -->
                        <div id="comments" class="comments-area">
                            <div class="list-comments">
                                <h3 class="comments-title">0 Comments</h3>
                                <div class="uni-divider"></div>
                                <!-- Comment list will be dynamic if you add comments table -->
                            </div>

                            <div class="form-comment">
                                <div id="respond" class="comment-respond">
                                    <h3 id="reply-title" class="comment-reply-title">Leave a Comment</h3>
                                    <div class="uni-divider"></div>
                                    <div class="row">
                                        <div class="uni-message-cause-form">
                                            <form action="#" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" id="yourmessage" name="message" placeholder="Your Comments" rows="5"></textarea>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <input type="text" id="yourName" placeholder="Name *" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <input type="email" id="youremail" placeholder="Email *" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <input type="url" id="website" placeholder="Website" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <div class="vk-btn-send">
                                                            <button type="submit" class="btn vk-btn-primary">Post Comment</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Sidebar (same as blog listing) -->
            <div class="col-md-4">
                <div class="uni-blog-list-right">
                    <aside id="secondary" class="widget-area">
                        <!-- Search -->
                        <aside class="widget">
                            <div class="widget-content">
                                <div class="uni-search-sidebar">
                                    <form action="#" method="get">
                                        <div class="vk-newlist-banner-test-search">
                                            <input type="text" name="s" placeholder="Search...">
                                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </aside>

                        <!-- Categories -->
                        @if($categories->count())
                        <aside class="widget">
                            <h3 class="widget-title">Category</h3>
                            <div class="uni-divider"></div>
                            <div class="widget-content">
                                <div class="uni-widget-category">
                                    <ul>
                                        @foreach($categories as $category)
                                        <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> {{ $category }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        @endif

                        <!-- Recent Posts -->
                        @if($recentPosts->count())
                        <aside class="widget">
                            <h3 class="widget-title">Recent Posts</h3>
                            <div class="uni-divider"></div>
                            <div class="widget-content">
                                <div class="uni-widget-popular-posts">
                                    <ul>
                                        @foreach($recentPosts as $post)
                                        <li>
                                            <div class="item-widget-popular-post">
                                                <div class="item-img">
                                                    <a href="{{ route('frontend.blog.show', $post->slug) }}">
                                                        <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('images/default.jpg') }}" alt="{{ $post->title }}">
                                                    </a>
                                                </div>
                                                <div class="item-caption">
                                                    <h4><a href="{{ route('frontend.blog.show', $post->slug) }}">{{ $post->title }}</a></h4>
                                                    <div class="time"><i class="fa fa-calendar" aria-hidden="true"></i> {{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        @endif

                        <!-- Archives -->
                        @if($archives->count())
                        <aside class="widget">
                            <h3 class="widget-title">Archives</h3>
                            <div class="uni-divider"></div>
                            <div class="widget-content">
                                <div class="uni-widget-archive">
                                    <ul>
                                        @foreach($archives as $archive)
                                        <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> {{ date('F Y', mktime(0,0,0,$archive->month,1,$archive->year)) }} ({{ $archive->count }})</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        @endif

                        <!-- Tags -->
                        @if($allTags->count())
                        <aside class="widget">
                            <h3 class="widget-title">Tags Cloud</h3>
                            <div class="uni-divider"></div>
                            <div class="widget-content">
                                <div class="uni-widget-tagsclound">
                                    <ul>
                                        @foreach($allTags as $tag)
                                        <li><a href="#">{{ $tag }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection