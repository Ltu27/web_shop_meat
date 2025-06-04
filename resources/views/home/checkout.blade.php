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
                        <form action="" method="post">
                            @csrf
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
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit">{{ __('common.checkout.cash_payment') }}</button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn-payment-online" type="submit" name="redirect">
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
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng giá</th>
                                </tr>
                            </thead>
                            @php
                                $total_vnpay = 0;
                            @endphp
                            <tbody>
                                @foreach ($carts as $item)
                                    @php
                                        $total_vnpay += $item->price * $item->quantity;
                                    @endphp
                                    <tr>
                                        <td scope="row">{{ $loop->index + 1 }}</td>
                                        <td>
                                            <img src="uploads/product/{{ $item->prod->image }}" width="40" alt="">    
                                        </td>
                                        <td>{{ $item->prod->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>
                                            <form action="{{ route('cart.update', $item->product_id) }}" method="get">
                                                <input type="number" value="{{ $item->quantity }}" name="quantity" 
                                                style="width: 60px; text-align:center">
                                                <button><i class="fa fa-save"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            {{ $item->price * $item->quantity }}
                                        </td>
                                        <td>
                                            <a title="Xóa sản phẩm khỏi giỏ hàng" onclick="return confirm('Are you suare want to delete product?')" 
                                            href="{{ route('cart.delete', $item->product_id) }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
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
    <script>
        $(document).ready(function() {
            $('.btn-payment-online').on('click', function(e) {
                e.preventDefault();
                var total_vnpay = $('input[name="total_vnpay"]').val();
                
                if (total_vnpay) {
                    $.ajax({
                        url: "{{ route('order.payment.online') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            total_vnpay: total_vnpay
                        },
                        success: function(response) {
                            if (response.code == '00') {
                                // toastr.success('Tạo yêu cầu thanh toán thành công. Đang chuyển hướng...');
                                // setTimeout(function () {
                                    window.location.href = response.data;
                                // }, 1000);
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
        });
    </script>
@endsection