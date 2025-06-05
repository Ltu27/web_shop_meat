@extends('master.main')
@section('title', $product->name)
@section('css')
<style>
    .variant-options {
        display: flex;
        gap: 8px;
        margin: 10px 0;
    }
    .variant-color {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #ccc;
        box-shadow: 0 0 2px rgba(0,0,0,0.3);
    }
    .variant-color.active {
        border: 2px solid #333;
    }
</style>
@endsection


@section('main')
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">{{ $product->name }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    @php
        $firstVariant = $product->variants->first();
    @endphp
    <!-- shop-details-area -->
    <section class="shop-details-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="shop-details-images-wrap">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane show active" id="itemOne-tab-pane" role="tabpanel" aria-labelledby="itemOne-tab" tabindex="0">
                                <a href="uploads/product/{{ $product->image }}" class="popup-image">
                                    <img id="big-img" src="uploads/product/{{ $product->image }}" alt="{{ $product->name }}" width="100%">
                                </a>
                            </div>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link  active">
                                    <img class="thumb-image" src="uploads/product/{{ $product->image }}" alt="" width="125px">
                                </button>
                            </li>
                            @foreach ($product->images as $img)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link  active">
                                        <img class="thumb-image" src="uploads/product/{{ $img->image }}" alt="" width="125px">
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shop-details-content">
                        <h2 class="title">{{ $product->name }}</h2>
                        <div class="review-wrap">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span>(4 nhận xét)</span>
                        </div>
                        <h3 class="price" id="main-price">
                            {{ number_format($firstVariant ? $firstVariant->variant_price : (
                            $product->coupon ? 
                                caculatePriceOfProduct($product->price, $product->coupon->value, $product->coupon->type)
                                : $product->price
                        ), 0, ',', '.') }} VNĐ
                        </h3>
                        <div class="product-count-wrap">
                            <span class="title">Nhanh tay! Giảm giá sẽ hết sau:</span>
                            <div class="coming-time" data-countdown="2024/6/13"></div>
                        </div>
                        
                        <p class="productIndfo__category-text">Số lượng trong kho: 
                            <span id="stock-quantity">{{ $firstVariant ? $firstVariant->stock_quantity : $product->stock_quantity ?? 0 }}</span>
                        </p>
                        @if ($firstVariant)
                            <p class="productIndfo__category-text">Ngày sản xuất: <span id="production-date">{{ $firstVariant->production_date }}</span></p>
                            <p class="productIndfo__category-text">Hạn sử dụng: <span id="expiration-date">{{ $firstVariant->expiration_date }}</span></p>
                        @endif
                        
                        @if($product->variants->count())
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="productInfo__variants">
                                        <label>Chọn màu:</label>
                                        <div class="variant-options">
                                            @foreach($product->variants as $variant)
                                                <span class="variant-color" 
                                                    data-variant-id="{{ $variant->id }}"
                                                    data-price="{{ number_format($variant->variant_price, 0, ',', '.') }}"
                                                    data-stock="{{ $variant->stock_quantity }}"
                                                    data-production="{{ $variant->production_date }}"
                                                    data-expiration="{{ $variant->expiration_date }}"
                                                    style="background-color: {{ $variant->variant_color }};" 
                                                    title="{{ $variant->variant_color }}">
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="productInfo__variants">
                                        <label>Số lượng:</label>
                                        <div class="variant-options">
                                            <div class="product-cart-wrap">
                                                <div class="cart-plus-minus">
                                                    <input type="text" id="quantity" name="quantity" value="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>
                            </div>
                            
                        @endif
                        
                        <p>{{ $product->description }}</p>
                        <button type="button" class="buy-btn" id="add-to-cart-btn"
                            data-product-id="{{ $product->id }}">
                            Thêm vào giỏ hàng
                        </button>
                        <div class="payment-method-wrap">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-desc-wrap">
                        <ul class="nav nav-tabs" id="descriptionTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane" aria-selected="true">Mô tả</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane" type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">Nhận xét (0)</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="descriptionTabContent">
                            <div class="tab-pane fade show active" id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                                <div class="product-description-content">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab" tabindex="0">
                                <div class="product-desc-review">
                                    <div class="product-desc-review-title mb-15">
                                        <h5 class="title">Khách hàng nhận xét (0)</h5>
                                    </div>
                                    <div class="left-rc">
                                        <p>Chưa có nhận xét</p>
                                    </div>
                                    <div class="right-rc">
                                        <a href="#">Viết nhận xét mới</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- shop-details-area-end -->

    <!-- product-area -->
    <section class="related-product-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb-50">
                        <span class="sub-title">THE FACE SHOP</span>
                        <h2 class="title">Sản phẩm đề xuất</h2>
                        <div class="title-shape" data-background="uploads/images/title_shape.png"></div>
                    </div>
                </div>
            </div>
            <div class="product-item-wrap-three">
                <div class="row justify-content-center rp-active">
                    @foreach ($products as $item)
                        <div class="col-xl-3">
                            <div class="product-item-three inner-product-item">
                                <div class="product-thumb-three">
                                    <a href="{{ route('home.product', $item->id) }}"><img src="uploads/product/{{ $item->image }}" alt=""></a>
                                    <span class="batch">Mới<i class="fas fa-star"></i></span>
                                </div>
                                <div class="product-content-three">
                                    <a href="{{ route('home.category', $item->cat) }}" class="tag">{{ $item->cat->name }}</a>
                                    <h2 class="title"><a href="{{ route('home.product', $item->id) }}">{{ $item->name }}</a></h2>
                                    <h2 class="price">{{ $item->sale_price }} VNĐ</h2>
                                    <div class="product-cart-wrap">
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
    </section>
    <!-- product-area-end -->

</main>
<!-- main-area-end -->
@stop()

@section('js')
<script>
    $('.thumb-image').click(function(e) {
        e.preventDefault();

        var _url = $(this).attr('src');

        $('#big-img').attr('src', _url)
    })
</script>
<script>
    let selectedVariantId = {{ $firstVariant ? $firstVariant->id : 'null' }};

    $('.variant-color').on('click', function () {
        $('.variant-color').removeClass('active');
        $(this).addClass('active');
        
        selectedVariantId = $(this).data('variant-id');

        $('#main-price').text($(this).data('price') + ' VNĐ');
        $('#stock-quantity').text($(this).data('stock'));
        $('#production-date').text($(this).data('production'));
        $('#expiration-date').text($(this).data('expiration'));
    });

    $('#add-to-cart-btn').on('click', function () {
        let productId = $(this).data('product-id');
        const quantity = parseInt($('#quantity').val());

        if (!selectedVariantId) {
            $.toast({
                heading: 'Lỗi',
                text: 'Vui lòng chọn phiên bản sản phẩm!',
                showHideTransition: 'slide',
                icon: 'error',
                position: 'top-center',
            });
            return;
        }

        $.ajax({
            url: '{{ route('api.cart.add', ":id") }}'.replace(':id', productId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                variant_id: selectedVariantId,
                quantity: quantity
            },
            success: function (res) {
                $.toast({
                    heading: 'Thành công',
                    text: 'Đã thêm vào giỏ hàng!',
                    showHideTransition: 'slide',
                    icon: 'success',
                    position: 'top-center',
                });
            },
            error: function (err) {
                let message = 'Có lỗi xảy ra!';
                if (err.responseJSON && err.responseJSON.message) {
                    message = err.responseJSON.message;
                }

                $.toast({
                    heading: 'Lỗi',
                    text: message,
                    showHideTransition: 'slide',
                    icon: 'error',
                    position: 'top-center',
                });
            }
        });
    });

</script>

@stop()