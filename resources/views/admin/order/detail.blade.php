@extends('master.admin')
@section('title', 'Chi tiết đơn hàng')
@section('main')
    
@if ($order->status != 2)
    @if ($order->status != 3)
    <a href="{{ route('order.update', $order->id) }}?status=2" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn chứ?')">Đã vận chuyển</a>
    <a href="{{ route('order.update', $order->id) }}?status=3" class="btn btn-warning" onclick="return confirm('Bạn chắc chắn chứ?')">Đã hủy</a>
    @else 
    <a href="{{ route('order.update', $order->id) }}?status=1" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn chứ?')">Khôi phục</a>
    @endif
@endif
<div class="row">
    <div class="col-md-6">
        <h3>Thông tin khách hàng</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <td>{{ $auth->name }}</td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td>{{ $auth->phone }}</td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td>{{ $auth->address }}</td>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-md-6">
        <h3>Thông tin giao hàng</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <td>{{ $order->name }}</td>
                </tr>
                <tr>
                    <th>Đô điện thoại</th>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td>{{ $order->address }}</td>
                </tr>
            </thead>
        </table>
    </div>
</div>
<h3>Thông tin sản phẩm</h3>
<table class="table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng sản phẩm</th>
            <th>Giá sản phẩm</th>
            <th>Tổng giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->details as $item)
            <tr>
                <td scope="row">{{ $loop->index + 1 }}</td>
                <td>
                    <img src="uploads/product/{{ $item->product->image }}" width="40" alt="">    
                </td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price) }}</td>
                <td>{{ number_format($item->price * $item->quantity) }}</td>
            </tr>
        @endforeach
        
    </tbody>
</table>

@stop()