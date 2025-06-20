@extends('master.main')
@section('title', 'Bài viết')
@section('main')
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Bài viết</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Bài viết</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- blog-area -->
    <section class="blog-area blog-bg" data-background="assets/img/bg/blog_bg.jpg">
        <div class="container custom-container-five">
            <div class="blog-inner-wrap">
                <div class="row justify-content-center">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-8">
                            <div class="blog-item">
                                <div class="blog-thumb">
                                    <a href=") }}">
                                        <img src="{{ $blog->image ? asset('uploads/blogs/' . $blog->image) : asset('assets/img/blog/default.jpg') }}" alt="{{ $blog->name }}">
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta-two">
                                        <ul class="list-wrap">
                                            <li><a href="#">{{ $blog->name }}</a></li>
                                            <li><a href="#"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</a></li>
                                        </ul>
                                    </div>
                                    <h2 class="title">
                                        <a href="">{{ $blog->name }}</a>
                                    </h2>
                                    <p>{{ \Str::limit($blog->description, 150) }}</p>
                                    <a href="" class="link-btn">
                                        Đọc tiếp <i class="fas fa-angle-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- <div class="col-lg-4 col-md-8">
                        <div class="blog-sidebar">
                            <div class="blog-widget">
                                <h4 class="sw-title">Search</h4>
                                <div class="sidebar-search">
                                    <form action="#">
                                        <input type="text" placeholder="Search...">
                                        <button type="submit"><i class="flaticon-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="blog-widget">
                                <h4 class="sw-title">Category</h4>
                                <div class="sidebar-cat-list">
                                    <ul class="list-wrap">
                                        <li><a href="#">Horse Meat <span>(3)</span></a></li>
                                        <li><a href="#">Branding <span>(5)</span></a></li>
                                        <li><a href="#">Gallery <span>(3)</span></a></li>
                                        <li><a href="#">Fresh Meat <span>(2)</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="blog-widget">
                                <h4 class="sw-title">Recent Post</h4>
                                <div class="rc-post-list">
                                    <div class="rc-post-item">
                                        <div class="thumb">
                                            <a href="blog-details.html"><img src="assets/img/blog/rc_post_img01.jpg" alt=""></a>
                                        </div>
                                        <div class="content">
                                            <h4 class="title"><a href="blog-details.html">Sources of protein elit</a></h4>
                                            <span class="date"><i class="fas fa-calendar-alt"></i>January 30, 2023</span>
                                        </div>
                                    </div>
                                    <div class="rc-post-item">
                                        <div class="thumb">
                                            <a href="blog-details.html"><img src="assets/img/blog/rc_post_img02.jpg" alt=""></a>
                                        </div>
                                        <div class="content">
                                            <h4 class="title"><a href="blog-details.html">Different Types Meat</a></h4>
                                            <span class="date"><i class="fas fa-calendar-alt"></i>January 30, 2023</span>
                                        </div>
                                    </div>
                                    <div class="rc-post-item">
                                        <div class="thumb">
                                            <a href="blog-details.html"><img src="assets/img/blog/rc_post_img03.jpg" alt=""></a>
                                        </div>
                                        <div class="content">
                                            <h4 class="title"><a href="blog-details.html">Eat meat and poultry</a></h4>
                                            <span class="date"><i class="fas fa-calendar-alt"></i>January 30, 2023</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-widget">
                                <div class="sidebar-add-banner">
                                    <a href="#"><img src="assets/img/blog/add_banner.jpg" alt=""></a>
                                </div>
                            </div>
                            <div class="blog-widget">
                                <h4 class="sw-title">Tags</h4>
                                <div class="sidebar-tag-list">
                                    <ul class="list-wrap">
                                        <li><a href="#">Food</a></li>
                                        <li><a href="#">Business</a></li>
                                        <li><a href="#">Types</a></li>
                                        <li><a href="#">Cow Meats</a></li>
                                        <li><a href="#">Protein</a></li>
                                        <li><a href="#">Horse Meat</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- blog-area-end -->

</main>
@endsection
