@extends('master.main')
@section('title', 'Giỏ hàng')
@section('main')
    
<!-- main-area -->
<main>

    <!-- breadcrumb-area -->
    <section class="breadcrumb-area tg-motion-effects breadcrumb-bg" data-background="uploads/bg/breadcrumb_bg.jpg">
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carts as $item)
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