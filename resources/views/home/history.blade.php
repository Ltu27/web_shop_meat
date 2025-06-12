@extends('master.main')
@section('title', 'Lịch sử đơn hàng')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/chup_anh_my_pham.webp">
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
                                    @switch($item->status)
                                        @case(0)
                                            <span class="badge bg-secondary">Chờ xác nhận</span>
                                            @break
                                
                                        @case(1)
                                            <span class="badge bg-info">Đã xác nhận</span>
                                            @break

                                        @case(2)
                                            <span class="badge bg-dark">Chưa thanh toán</span>
                                            @break
                                
                                        @case(3)
                                            <span class="badge bg-success">Đã thanh toán</span>
                                            @break

                                        @case(4)
                                            <span class="badge bg-warning">Đã nhận hàng</span>
                                            @break
                                
                                        @case(6)
                                            <span class="badge bg-danger">Đã hủy</span>
                                            @break
                                
                                        @default
                                            <span class="badge bg-secondary">Không xác định</span>
                                    @endswitch
                                </td>
                                <td>{{ number_format($item->totalPrice) }}</td>
                                <td>
                                    <a href="{{ route('order.detail', $item->id) }}" class="btn btn-sm btn-primary">Chi tiết</a>
                                    
                                    @if ($item->status == 0)
                                        <form action="{{ route('order.cancel', $item->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">Hủy đơn</button>
                                        </form>
                                    @endif
                                </td>                                
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                <br>
                <div class="text-center">
                    <a href="" class="btn btn-primary">Tiếp tục mua hàng</a>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-area-end -->

</main>
<!-- main-area-end -->


@endsection