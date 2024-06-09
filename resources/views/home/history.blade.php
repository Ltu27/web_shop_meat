@extends('master.main')
@section('title', 'Lịch sử đơn hàng')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/breadcrumb_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Lịch sử đơn hàng</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Lịch sử đơn hàng</li>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($auth->orders as $item)
                            <tr>
                                <td scope="row">{{ $loop->index + 1 }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if ($item->status == 0)
                                    <span>Chưa xác nhận</span>
                                    @elseif ($item->status == 1)
                                    <span>Đã xác nhận</span>  
                                    @elseif ($item->status == 2)
                                    <span>Đã thanh toán</span>  
                                    @else 
                                    <span>Đã hủy</span>    
                                    @endif
                                </td>
                                <td>{{ number_format($item->totalPrice) }}</td>
                                <td>
                                    <a href="{{ route('order.detail', $item->id) }}" class="btn btn-sm btn-primary">Chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                <br>
                <div class="text-center">
                    <a href="" class="btn btn-primary">Tiếp tục mua hàng</a>
                    @if ($carts->count())
                        <a href="{{ route('cart.clear') }}" class="btn btn-danger" onclick="return confirm('Are you suare want to delete all product?')">Xóa tất cả</a>
                        <a href="{{ route('order.checkout') }}" class="btn btn-success">Đặt hàng</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- contact-area-end -->

</main>
<!-- main-area-end -->


@endsection