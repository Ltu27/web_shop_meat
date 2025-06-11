@extends('master.main')
@section('title', 'Giỏ hàng')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Giỏ hàng</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- contact-area -->
    <section class="contact-area">
        
        <div class="contact-wrap">
            <div class="container">
                <form action="{{ route('order.checkout.post') }}" method="POST" id="checkout-form">
                    @csrf
                    <table class="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"> </th>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Màu</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="cart-item" name="products[]" value="{{ $item->id }}">
                                    </td>
                                    <td scope="row">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <img src="uploads/product/{{ $item->prod->image }}" width="40" alt="">    
                                    </td>
                                    <td>{{ $item->prod->name }}</td>
                                    <td>
                                        @if ($item->variant && $item->variant->variant_color)
                                            <div style="width: 20px; height: 20px; margin-top: 5px; border-radius: 50%; background-color: {{ $item->variant->variant_color }}; border: 1px solid #ccc;" title="{{ $item->variant->variant_color }}"></div>
                                        @else
                                            <span>Không có</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->price }}</td>
                                    <td>
                                        <div class="update-cart-form" data-id="{{ $item->product_id }}" 
                                            data-variant-id="{{ $item->variant_id }}">
                                            @csrf
                                            <input type="number" value="{{ $item->quantity }}" 
                                                name="quantity" class="quantity-input" style="width: 60px; text-align:center">
                                            <button type="button" class="update-btn"><i class="fa fa-save"></i></button>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <a title="Xóa sản phẩm khỏi giỏ hàng" onclick="return confirm('Are you suare want to delete product?')" 
                                        href="{{ route('cart.delete', $item->product_id) }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    <br>
                    <div class="text-center">
                        <a href="" class="btn btn-primary">Tiếp tục mua sắm</a>
                        @if ($carts->count())
                            <a href="{{ route('cart.clear') }}" class="btn btn-danger" onclick="return confirm('Are you suare want to delete all product?')">Xóa giỏ hàng</a>
                            <button type="submit" class="btn btn-success">Đặt hàng</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- contact-area-end -->

</main>
<!-- main-area-end -->
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('.update-btn').on('click', function(e) {
            const form = $(this).closest('.update-cart-form');
            const productId = form.data('id');
            const variantId = form.data('variant-id');
            const quantity = form.find('.quantity-input').val();

            $.ajax({
                url: '/cart/update-quantity/' + productId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity,
                    variant_id: variantId,
                    product_id: productId
                },
                success: function(response) {
                    $.toast({
                        heading: 'Thông báo',
                        text: 'Cập nhật giỏ hàng thành công',
                        showHideTransition: 'slide',
                        icon: 'success',
                        position: 'top-center',
                    });
                },
                error: function() {
                    $.toast({
                        heading: 'Thông báo',
                        text: 'Đã xảy ra lỗi khi cập nhật',
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-center',
                    });
                }
            });
        });


        $('#checkAll').on('change', function() {
            $('.cart-item').prop('checked', $(this).is(':checked'));
        });
    });
</script>
@endsection