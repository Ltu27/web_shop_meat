@extends('master.admin')
@section('title', 'Chi tiết đơn hàng')
@section('main')
    
@php
    use App\Constants\OrderConstant;
@endphp

@switch($order->status)

    @case(OrderConstant::STATUS_PENDING) 
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_CONFIRMED }}" class="btn btn-success" onclick="return confirm('Xác nhận đơn hàng?')">Xác nhận</a>
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_COMPLETED }}" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng?')">Hủy</a>
        @break

    @case(OrderConstant::STATUS_CONFIRMED) 
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_NOT_YET_PAY }}" class="btn btn-primary" onclick="return confirm('Chuyển sang chưa thanh toán?')">Chưa thanh toán</a>
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_COMPLETED }}" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng?')">Hủy</a>
        @break

    @case(OrderConstant::STATUS_NOT_YET_PAY) 
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_PAID }}" class="btn btn-info" onclick="return confirm('Xác nhận đã thanh toán?')">Đã thanh toán</a>
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_COMPLETED }}" class="btn btn-danger" onclick="return confirm('Hủy đơn hàng?')">Hủy</a>
        @break

    @case(OrderConstant::STATUS_PAID) 
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_DONE }}" class="btn btn-primary" onclick="return confirm('Khách đã nhận hàng?')">Đã nhận hàng</a>
        <a href="{{ route('order.update', $order->id) }}?status={{ OrderConstant::STATUS_COMPLETED }}" class="btn btn-danger" onclick="return confirm('Khách đã hủy đơn hàng?')">Đã hủy</a>
        @break

    @case(OrderConstant::STATUS_DONE) 
        <span class="badge bg-success">Hoàn thành</span>
        @break

    @default
        <span class="badge bg-secondary">Đã hủy</span>
@endswitch

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
        <tr>
            <td class="text-end"><strong>Tổng giá sau khi giảm giá:</strong>
                <strong>{{ number_format($order->total_price) }} (VNĐ)</strong>
            </td>
        </tr>
        
    </tbody>
</table>

@stop()