@extends('master.main')
@section('title', __('common.title.checkout'))
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content"> 
                        <h2 class="title">{{ __('common.title.checkout') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">{{ __('common.home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('common.title.checkout') }}</li>
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
                <div class="row">
                    <div class="col-md-4">
                        <form action="{{ route('order.postCheckout') }}" method="post">
                            @csrf
                            @if (isset($cartsChoosen))
                                @foreach ($cartsChoosen as $item)
                                    <input type="hidden" name="cart_ids[]" value="{{ $item->id }}">
                                @endforeach
                            @endif
                            <div class="contact-form-wrap">
                                <div class="form-grp">
                                    <input name="name" value="{{ $auth->name }}" class="form-control" type="text" placeholder="Your Name *" required>
                                    @error('name')
                                        <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-grp">
                                    <input name="email" value="{{ $auth->email }}" class="form-control" type="email" placeholder="Your Email *" required>
                                    @error('email')
                                        <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-grp">
                                    <input name="phone" value="{{ $auth->phone }}" class="form-control" type="text" placeholder="Your Phone *" required>
                                    @error('phone')
                                        <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-grp">
                                    <input name="address" value="{{ $auth->address }}" class="form-control" type="text" placeholder="Your Address *" required>
                                    @error('address')
                                        <div class="help-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-grp">
                                    <label for="coupon_id">Chọn mã giảm giá</label>
                                    <select name="coupon_id" id="coupon_id" class="form-control">
                                        <option value="" data-discount="0">-- Không áp dụng --</option>
                                        @foreach ($coupons as $coupon)
                                            <option value="{{ $coupon->id }}" data-discount="{{ $coupon->discount }}">
                                                {{ $coupon->code }} - Giảm {{ (int)$coupon->discount }}%
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit">{{ __('common.checkout.cash_payment') }}</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn-payment-online" type="button" name="redirect">
                                            {{ __('common.checkout.online') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Màu</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng giá</th>
                                    <th>Thành tiền sau giảm</th>
                                </tr>
                            </thead>
                            @php
                                $total_vnpay = 0;
                            @endphp
                            <tbody>
                                @if (!isset($cartsChoosen))
                                    <tr>
                                        <td colspan="8" class="text-center">Giỏ hàng trống</td>
                                    </tr>
                                @else
                                    @foreach ($cartsChoosen as $item)
                                        @php
                                            $total_vnpay += $item->price * $item->quantity;
                                        @endphp
                                        <tr>
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
                                                <form class="update-cart-form" data-id="{{ $item->product_id }}" 
                                                    data-variant-id="{{ $item->variant_id }}"
                                                    @csrf
                                                    <input type="number" value="{{ $item->quantity }}" name="quantity" 
                                                        class="quantity-input" style="width: 60px; text-align:center">
                                                    <button type="submit"><i class="fa fa-save"></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                {{ $item->price * $item->quantity }}
                                            </td>
                                            @php
                                                $total = $item->price * $item->quantity;
                                            @endphp
                                            <td class="discounted-price" data-original="{{ $total }}">
                                                {{ number_format($total, 0, ',', '.') }} đ
                                            </td>
                                            <td>
                                                <a title="Xóa sản phẩm khỏi giỏ hàng" onclick="return confirm('Are you suare want to delete product?')" 
                                                href="{{ route('cart.delete', $item->product_id) }}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="text-start"><strong>Tổng giá sau khi giảm giá:</strong></td>
                                        <td><strong>{{ number_format($total_vnpay) }}</strong></td>
                                        <td id="total-after-discount"><strong>{{ number_format($total_vnpay) }} đ</strong></td>
                                    </tr>
                                @endif
                                <input type="hidden" name="total_vnpay" value="{{ $total_vnpay }}">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-area-end -->

</main>
<!-- main-area-end -->


@endsection
@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            @if(session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if(session('error'))
                toastr.error('{{ session('error') }}');
            @endif

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === '1') {
                toastr.success('Thanh toán thành công!');
            }

            if (urlParams.get('success') === '0') {
                toastr.error('Thanh toán thất bại!');
            }

            $('.btn-payment-online').on('click', function(e) {
                e.preventDefault();

                let total_vnpay = 0;
                const discountPercent = parseFloat($('#coupon_id option:selected').data('discount')) || 0;

                $('.discounted-price').each(function () {
                    const original = parseFloat($(this).data('original'));
                    const discounted = original * (1 - discountPercent / 100);
                    total_vnpay += discounted;
                });

                var cartIds = [];
                $('input[name="cart_ids[]"]').each(function() {
                    cartIds.push($(this).val());
                });

                if (total_vnpay > 0) {
                    $.ajax({
                        url: "{{ route('order.payment.online') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            total_vnpay: Math.round(total_vnpay), 
                            cart_ids: cartIds,
                            coupon_id: $('#coupon_id').val()
                        },
                        success: function(response) {
                            if (response.code == '00') {
                                window.location.href = response.data;
                            } else {
                                alert('Có lỗi khi tạo yêu cầu thanh toán.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Payment error:', error);
                            alert('There was an error processing your payment. Please try again.');
                        }
                    });
                } else {
                    alert('Total amount is required for online payment.');
                }
            });


            $('.update-cart-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
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
        });

        $('#coupon_id').on('change', function () {
            const selectedOption = $(this).find('option:selected');
            const discountPercent = parseFloat(selectedOption.data('discount')) || 0;
            let totalAfterDiscount = 0;

            $('.discounted-price').each(function () {
                const original = parseFloat($(this).data('original'));
                const discounted = original * (1 - discountPercent / 100);
                $(this).text(discounted.toLocaleString('vi-VN') + ' đ');
                totalAfterDiscount += discounted;
            });

            $('#total-after-discount').html('<strong>' + totalAfterDiscount.toLocaleString('vi-VN') + ' đ</strong>');
        });

    </script>
@endsection