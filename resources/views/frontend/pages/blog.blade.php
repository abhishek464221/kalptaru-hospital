@extends('frontend.layouts.app')

@section('title', 'Blog - Kalptaru Hospital')

@section('content')
<div class="uni-banner-default uni-background-1">
    <div class="container">
        <div class="page-title">
            <div class="page-title-inner">
                <h1>Blog List</h1>
            </div>
        </div>
        <ul class="breadcrumbs">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">List</a></li>
        </ul>
    </div>
</div>

<div class="uni-blog-list-body">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="uni-blog-list-left">

                    @forelse($blogs as $blog)
                    <!-- Single Blog Item -->
                    <div class="blog-list-item">
                        <article class="post type-post">
                            <div class="content-inner">
                                <div class="uni-entry-top">
                                    @if($blog->featured_image)
                                    <div class="thumbnail-img">
                                        <a href="{{ route('frontend.blog.show', $blog->slug) }}" title="{{ $blog->title }}">
                                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="img-responsive" width="100%">
                                        </a>
                                    </div>
                                    @else
                                    <!-- No image fallback -->
                                    <div style="background:#f0f0f0; height:200px; display:flex; align-items:center; justify-content:center;">
                                        <span>No Image</span>
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
                                            <h2 class="uni-entry-title">
                                                <a href="{{ route('frontend.blog.show', $blog->slug) }}" rel="bookmark">{{ $blog->title }}</a>
                                            </h2>
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
                                        </div>
                                        <div class="uni-entry-summary">
                                            <p>{{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}</p>
                                        </div>
                                        <div class="readmore">
                                            <a href="{{ route('frontend.blog.show', $blog->slug) }}"><i class="icomoon icon-up"></i>Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    @empty
                    <div class="alert alert-info">No blog posts found.</div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="uni-divider"></div>
                    <div class="uni-pagination-blog">
                        {{ $blogs->links() }}
                    </div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="uni-blog-list-right">
                    <aside id="secondary" class="widget-area">
                        <!-- Search Widget -->
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

                        <!-- Categories Widget -->
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

                        <!-- Recent Posts Widget -->
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

                        <!-- Archives Widget -->
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

                        <!-- Tags Cloud Widget -->
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