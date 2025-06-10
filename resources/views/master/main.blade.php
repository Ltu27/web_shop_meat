<!doctype html>
<html class="no-js" lang="en">
    
<!-- Mirrored from themegenix.net/html/bemet/about.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Nov 2023 02:25:48 GMT -->
    <head>
        <base href="/">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title')</title>
        <meta name="description" content="Bemet - Butcher & Meat Shop HTML Template">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" type="image/x-icon" href="uploads/favicon.png">
        <!-- Place favicon.ico in the root directory -->

        <!-- CSS here -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/css/flaticon.css">
        <link rel="stylesheet" href="assets/css/odometer.css">
        <link rel="stylesheet" href="assets/css/jquery-ui.css">
        <link rel="stylesheet" href="assets/css/slick.css">
        <link rel="stylesheet" href="assets/css/default.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        @yield('css')
    </head>
    <body>

        <!-- preloader -->
        <div id="preloader">
            <div id="loading-center">
                <div class="loader">
                    <div class="loader-outter"></div>
                    <div class="loader-inner"></div>
                </div>
            </div>
        </div>
        <!-- preloader-end -->

		<!-- Scroll-top -->
        <button class="scroll-top scroll-to-target" data-target="html">
            <i class="fas fa-angle-up"></i>
        </button>
        <!-- Scroll-top-end-->

        <!-- header-area -->
        <header class="transparent-header">
            <div class="header-top-wrap">
                <div class="container custom-container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="header-top-left">
                                <ul class="list-wrap">
                                    <li class="header-location" style="font-size: 16px">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Ha Noi. Viet Nam
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4">
                            <div class="header-top-right">
                                <div class="header-top-menu">
                                    <ul class="list-wrap">
                                        @if (auth('cus')->check())
                                            <li><a style="font-size: 16px" href="{{ route('account.profile') }}">Xin chào {{ auth('cus')->user()->name }}</a></li>
                                            <li><a style="font-size: 16px" href="{{ route('account.change_password') }}">Thay đổi mật khẩu</a></li>
                                            <li><a style="font-size: 16px" href="{{ route('account.favorite') }}">Yêu thích</a></li>
                                            <li><a style="font-size: 16px" href="{{ route('order.history') }}">Đơn của tôi</a></li>
                                            <li><a style="font-size: 16px" href="{{ route('account.logout') }}">Đăng xuất</a></li>
                                            
                                        @else
                                            <li><a style="font-size: 16px" href="{{ route('account.login') }}">Đăng nhập</a></li>
                                            <li><a style="font-size: 16px" href="{{ route('account.register') }}">Đăng ký</a></li>
                                        @endif
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="sticky-header" class="menu-area">
                <div class="container custom-container">
                    <div class="row">
                        <div class="col-12">
                            <div class="menu-wrap">
                                <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                                <nav class="menu-nav">
                                    <div class="logo">
                                        <a href="#"><img src="uploads/logo/logo-web-hue.webp" alt="Logo"></a>
                                    </div>
                                    <div class="navbar-wrap main-menu d-none d-lg-flex">
                                        <ul class="navigation">
                                            <li class="active"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                            <li class=""><a href="{{ route('home.about') }}">Thông tin</a></li>
                                            <li class="menu-item-has-children"><a href="#">Sản phẩm</a>
                                                <ul class="sub-menu">
                                                    @foreach ($cats_home as $cath)
                                                        <li><a href="{{ route('home.category', $cath->id) }}">{{ $cath->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children"><a href="#">Bài viết</a>
                                                <ul class="sub-menu">
                                                    <li><a href="#">Our Blog</a></li>
                                                    <li><a href="#">Blog Details</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="header-action d-none d-md-block">
                                        <ul class="list-wrap">
                                            <li class="header-search">
                                                <a href="#"><i class="flaticon-search"></i></a>
                                            </li>
                                            <li class="header-shop-cart">
                                                <a href="{{ route('cart.index') }}">
                                                    <i class="flaticon-shopping-basket"></i>
                                                    <span>{{ $carts->sum('quantity') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>

                            <div class="mobile-menu">
                                <nav class="menu-box">
                                    <div class="close-btn"><i class="fas fa-times"></i></div>
                                    <div class="nav-logo">
                                        <a href="index-2.html"><img src="uploads/logo/logo.png" alt="Logo"></a>
                                    </div>
                                    <div class="menu-outer">
                                    </div>
                                    <div class="social-links">
                                        <ul class="clearfix list-wrap">
                                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                            <div class="menu-backdrop"></div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- header-search -->
            <div class="search-popup-wrap" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="search-wrap text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="search-form">
                                    <form action="{{ route('home.search') }}" method="POST">
                                        @csrf
                                        <input type="text" name="searchProduct" placeholder="Nhập tên sản phẩm...">
                                        <button class="search-btn"><i class="flaticon-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-backdrop"></div>
            <!-- header-search-end -->

        </header>
        <!-- header-area-end -->


        @yield('main')

        <!-- footer-area -->
        <footer>
            <div class="footer-area">
                <div class="footer-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="footer-widget">
                                    <h4 class="fw-title">Thông tin cửa hàng</h4>
                                    <div class="footer-contact">
                                        <ul class="list-wrap">
                                            <li>Hà nội, Việt Nam</li>
                                            <li><a href="tel:0123456789">+1 234 567 789</a></li>
                                            <li><a href="mailto:info@bemet.com">info@bemet.com</a></li>
                                        </ul>
                                    </div>
                                    <div class="footer-content">
                                        <h4 class="title">Giờ mở cửa</h4>
                                        <p>Tất cả ngày trong tuần <span>06:00-18:00</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="footer-widget">
                                    <h4 class="fw-title">Đường dẫn</h4>
                                    <div class="footer-link">
                                        <ul class="list-wrap">
                                            <li><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                            <li><a href="{{ route('home.about') }}">Thông tin</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 col-sm-4">
                                <div class="footer-widget">
                                    <h4 class="fw-title">Danh mục</h4>
                                    <div class="footer-link">
                                        <ul class="list-wrap">
                                            @foreach ($cats_home as $cath)
                                                <li><a href="{{ route('home.category', $cath->id) }}">{{ $cath->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-8">
                                <div class="footer-widget">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-7">
                                <div class="copyright-text">
                                    <p>HUE HUE <a href="{{ route('home.index') }}">THE FACE SHOP</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer-area-end -->

        <!-- JS here -->
        <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/imagesloaded.pkgd.min.js"></script>
        <script src="assets/js/jquery.countdown.min.js"></script>
        <script src="assets/js/jquery.magnific-popup.min.js"></script>
        <script src="assets/js/jquery.odometer.min.js"></script>
        <script src="assets/js/jquery.appear.js"></script>
        <script src="assets/js/tween-max.min.js"></script>
        <script src="assets/js/slick.min.js"></script>
        <script src="assets/js/slick-animation.min.js"></script>
        <script src="assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/ajax-form.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
        <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
        <df-messenger
        intent="WELCOME"
        chat-title="web_shop_meet"
        agent-id="40034e07-e5ab-490f-8626-e124de7425a9"
        language-code="vi"
        ></df-messenger>
        @if(Session::has('ok'))

        <script>
            $.toast({
                heading: 'Thông báo',
                text: '{{ Session::get('ok') }}',
                showHideTransition: 'slide',
                icon: 'success',
                position: 'top-center',        
            })
        </script>
        @endif

        @if(Session::has('no'))

        <script>
            $.toast({
                heading: 'Thông báo',
                text: '{{ Session::get('no') }}',
                showHideTransition: 'slide',
                icon: 'error',
                position: 'top-center',        
            })
        </script>
        @endif
        @yield('js')

    </body> 

</html>
