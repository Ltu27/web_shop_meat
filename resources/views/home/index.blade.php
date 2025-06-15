@extends('master.main')
@section('title', 'Trang chủ')

@section('main')
    
<!-- main-area -->
<main>

    <!-- area-bg -->
    <div class="area-bg" data-background="uploads/bg/area_bg.jpg">

        <!-- banner-area -->
        <section class="banner-area banner-bg tg-motion-effects" data-background="uploads/banner/pngtree-various.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="banner-content">
                            <a href="{{ route('cart.index') }}" class="btn wow fadeInUp" data-wow-delay=".6s">Đặt hàng ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner-area-end -->

        <!-- features-area -->
        <section class="features-area pt-130 pb-70">
            <div class="container">
                <div class="row">
                    @foreach ($new_products as $np)
                        <div class="col-lg-6">
                            <div class="features-item tg-motion-effects">
                                <div class="features-content">
                                    <span>{{ $np->cat->name }}</span>
                                    <h4 class="title"><a href="{{ route('home.product', $np->id) }}">{{ $np->name }}</a></h4>
                                    <div class="favorite-action">
                                        @if (auth('cus')->check())
                                            @if ($np->favorited)
                                                <a title="Bỏ thích" onclick="return confirm('Bạn có muốn bỏ thích không?')" 
                                                href="{{ route('home.favorite', $np->id) }}"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a title="Yêu thích" href="{{ route('home.favorite', $np->id) }}">
                                                    <i class="far fa-heart"></i></a>
                                            @endif
                                                <a title="Thêm vào giỏ hàng" href="{{ route('cart.add', $np->id) }}">
                                                    <i class="fa fa-shopping-cart"></i></a>
                                        @else
                                        <a title="Thêm vào giỏ hàng" href="{{ route('account.login') }}" 
                                        onclick="alert('Vui lòng đăng nhập để thêm giỏ hàng')"><i class="fa fa-shopping-cart"></i></a>
                                        @endif
                                    </div>
                                    @if (count($np->variants) > 0)
                                        <span class="price">{{ number_format($np->variants[0]->variant_price) }} VNĐ</span>
                                    @endif
                                </div>
                                <div class="features-img">
                                    <img src="uploads/product/{{ $np->image }}" alt="">
                                    <div class="features-shape">
                                        <img src="uploads/product/features_shape.png" alt="" class="tg-motion-effects4">
                                    </div>
                                </div>
                                <div class="features-overlay-shape" data-background="uploads/products/features_overlay.png"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- features-area-end -->

    </div>
    <!-- area-bg-end -->

    <!-- product-area -->
    {{-- <section class="product-area product-bg" data-background="uploads/bg/product_bg01.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb-60">
                        <span class="sub-title">THE FACE SHOP</span>
                        <h2 class="title">Giảm giá</h2>
                        <div class="title-shape" data-background="uploads/images/title_shape.png"></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($sale_products as $sp)
                    <div class="col-lg-4 col-md-6">
                        <div class="product-item">
                            <div class="product-img">
                                <a href="{{ route('home.product', $sp->id) }}"><img src="uploads/product/{{ $sp->image }}" alt=""></a>
                            </div>
                            <div class="product-content">
                                <div class="line" data-background="uploads/images/line.png"></div>
                                <h4 class="title"><a href="{{ route('home.product', $sp->id) }}">{{ $sp->name }}</a></h4>
                                    @if (count($sp->variants) > 0)
                                        <h6 class="price">{{ number_format($sp->variants[0]->variant_price) }} VNĐ</h6>
                                    @endif
                                    <div class="favorite-action">
                                        @if (auth('cus')->check())
                                            @if ($sp->favorited)
                                                <a title="Bỏ thích" onclick="return confirm('Bạn có muốn bỏ thích không?')" 
                                                href="{{ route('home.favorite', $sp->id) }}"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a title="Yêu thích" href="{{ route('home.favorite', $sp->id) }}">
                                                    <i class="far fa-heart"></i></a>
                                            @endif
                                                <a title="Thêm vào giỏ hàng" href="{{ route('cart.add', $sp->id) }}">
                                                    <i class="fa fa-shopping-cart"></i></a>
                                        @else
                                        <a title="Thêm vào giỏ hàng" href="{{ route('account.login') }}" 
                                        onclick="alert('Vui lòng đăng nhập để thêm giỏ hàng')"><i class="fa fa-shopping-cart"></i></a>
                                        @endif
                                    </div>
                            </div>
                            <div class="product-shape">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 401 314" preserveAspectRatio="none">
                                    <path d="M331.5,1829h361a20,20,0,0,1,20,20l-29,274a20,20,0,0,1-20,20h-292a20,20,0,0,1-20-20l-40-274A20,20,0,0,1,331.5,1829Z" transform="translate(-311.5 -1829)" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="shop-shape">
            <img src="uploads/product/product_shape01.png" alt="">
        </div>
    </section> --}}
    <!-- product-area-end -->

    <!-- gallery-area -->
    <div class="gallery-area gallery-bg" data-background="uploads/bg/product_bg01.jpg">
        <div class="container">
            <div class="gallery-item-wrap">
                <div class="row justify-content-center">
                    <div class="col-88">
                        <div class="gallery-active">
                            @foreach ($galleries as $ga)
                                <div class="gallery-item">
                                    <a href="uploads/gallery/{{ $ga->image }}" class="popup-image"><img src="uploads/gallery/gallery_img01.png" alt=""></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- gallery-area-end -->

    <!-- product-area -->
    <section class="product-area-two product-bg-two" data-background="uploads/bg/product_bg02.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb-70">
                        <span class="sub-title">THE FACE SHOP</span>
                        <h2 class="title">Sản phẩm đặc trưng</h2>
                        <div class="title-shape" data-background="uploads/images/title_shape.png"></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($feature_products as $fp)
                    <div class="col-lg-6 col-md-10">
                        <div class="product-item-two">
                            <div class="product-img-two">
                                <a href="{{ route('home.product', $fp->id) }}"><img src="uploads/product/{{ $fp->image }}" alt=""></a>
                            </div>
                            <div class="product-content-two">
                                <div class="product-info">
                                    <h4 class="title"><a href="{{ route('home.product', $fp->id) }}">{{ $fp->name }}</a></h4>
                                    <p>{{ $fp->description }}</p>
                                    <div class="favorite-action">
                                        @if (auth('cus')->check())
                                            @if ($fp->favorited)
                                                <a title="Bỏ thích" onclick="return confirm('Bạn có muốn bỏ thích không?')" 
                                                href="{{ route('home.favorite', $fp->id) }}"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a title="Yêu thích" href="{{ route('home.favorite', $fp->id) }}">
                                                    <i class="far fa-heart"></i></a>
                                            @endif
                                                <a title="Thêm vào giỏ hàng" href="{{ route('cart.add', $fp->id) }}">
                                                    <i class="fa fa-shopping-cart"></i></a>
                                        @else
                                        <a title="Thêm vào giỏ hàng" href="{{ route('account.login') }}" 
                                        onclick="alert('Vui lòng đăng nhập để thêm giỏ hàng')"><i class="fa fa-shopping-cart"></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="product-price">
                                    @if (count($fp->variants) > 0)
                                        <span class="price">{{ number_format($fp->variants[0]->variant_price) }} VNĐ</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="shop-now-btn text-center mt-40">
                <a href="{{ route('cart.index') }}" class="btn">Mua hàng ngay</a>
            </div>
        </div>
    </section>
    <!-- product-area-end -->

    <!-- faq-area -->
    <section class="faq-area tg-motion-effects faq-bg" data-background="uploads/bg/faq_bg.jpg">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-10">
                    <div class="faq-img-wrap">
                        <img src="uploads/images/anh2.jpg" alt="">
                        <img src="uploads/images/anh3.webp" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-content">
                        <div class="section-title mb-60">
                            <span class="sub-title">Ý kiến khách hàng</span>
                            <h2 class="title">Những <span>câu hỏi</span> thường gặp.</h2>
                        </div>
                        <div class="faq-wrap">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Sản phẩm chính hãng 100% từ thương hiệu uy tín
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>Tất cả sản phẩm đều được nhập khẩu chính ngạch hoặc phân phối từ nhà cung cấp chính thức, đảm bảo chất lượng và nguồn gốc rõ ràng.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Sản phẩm có phù hợp với da nhạy cảm không?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>Các sản phẩm đều được kiểm nghiệm da liễu, không chứa paraben hay hương liệu gây kích ứng. Phù hợp cho cả làn da nhạy cảm.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- faq-area-end -->

</main>
<!-- main-area-end -->

@stop