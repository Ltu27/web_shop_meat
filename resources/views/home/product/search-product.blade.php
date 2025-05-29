@extends('master.main')

@section('title', 'Kết quả tìm kiếm')
@section('main')

<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">THE FACE SHOP</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Kết quả tìm kiếm</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- shop-area -->
    <section class="shop-area shop-bg" data-background="assets/img/bg/shop_bg.jpg">
        <div class="container custom-container-five">
            <div class="shop-inner-wrap">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shop-top-wrap">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="shop-showing-result">
                                        <p>Showing 1–09 of 20 results</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="shop-ordering">
                                        <select name="orderby" class="orderby">
                                            <option value="Default sorting">Sort by Top Rating</option>
                                            <option value="Sort by popularity">Sort by popularity</option>
                                            <option value="Sort by average rating">Sort by average rating</option>
                                            <option value="Sort by latest">Sort by latest</option>
                                            <option value="Sort by latest">Sort by latest</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shop-item-wrap">
                            <div class="row justify-content-center">
                                @foreach ($products as $product)
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="product-item-three inner-product-item">
                                            <div class="product-thumb-three">
                                                <a href="{{ route('home.product', $product->id) }}"><img src="uploads/product/{{ $product->image }}" alt=""></a>
                                                <span class="batch">New<i class="fas fa-star"></i></span>
                                            </div>
                                            <div class="product-content-three">
                                                <a href="#" class="tag">{{ $product->cat->name }}</a>
                                                <h2 class="title"><a href="{{ route('home.product', $product->id) }}">{{ $product->name }}</a></h2>
                                                @if ($product->sale_price > 0)
                                                    <h2><s>{{ number_format($product->price) }} VNĐ</s></h2>
                                                    <h2 class="price">{{ number_format($product->sale_price) }} VNĐ</h2>
                                                @else
                                                    <h2 class="price">{{ number_format($product->price) }} VNĐ</h2>
                                                @endif
                                                <div class="favorite-action">
                                                    @if (auth('cus')->check())
                                                        @if ($product->favorited)
                                                            <a title="Bỏ thích" onclick="return confirm('Bạn có muốn bỏ thích không?')" 
                                                            href="{{ route('home.favorite', $product->id) }}"><i class="fas fa-heart"></i></a>
                                                        @else
                                                            <a title="Yêu thích" href="{{ route('home.favorite', $product->id) }}">
                                                                <i class="far fa-heart"></i></a>
                                                        @endif
                                                            <a title="Thêm vào giỏ hàng" href="{{ route('cart.add', $product->id) }}">
                                                                <i class="fa fa-shopping-cart"></i></a>
                                                    @else
                                                    <a title="Thêm vào giỏ hàng" href="{{ route('account.login') }}" 
                                                    onclick="alert('Vui lòng đăng nhập để thêm giỏ hàng')"><i class="fa fa-shopping-cart"></i></a>
                                                    @endif
                                                </div>
                                                <div class="product-cart-wrap">
                                                    <form action="#">
                                                        <div class="cart-plus-minus">
                                                            <input type="text" value="1">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="product-shape-two">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 303 445" preserveAspectRatio="none">
                                                    <path d="M319,3802H602c5.523,0,10,5.24,10,11.71l-10,421.58c0,6.47-4.477,11.71-10,11.71H329c-5.523,0-10-5.24-10-11.71l-10-421.58C309,3807.24,313.477,3802,319,3802Z" transform="translate(-309 -3802)" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- shop-area-end -->

</main>

@stop