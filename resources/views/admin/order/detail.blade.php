@extends('master.admin')
@section('title', 'Order detail')
@section('main')
    
@if ($order->status != 2)
    @if ($order->status != 3)
    <a href="{{ route('order.update', $order->id) }}?status=2" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delivered</a>
    <a href="{{ route('order.update', $order->id) }}?status=3" class="btn btn-warning" onclick="return confirm('Are you sure?')">Cancelled</a>
    @else 
    <a href="{{ route('order.update', $order->id) }}?status=1" class="btn btn-danger" onclick="return confirm('Are you sure?')">Restore</a>
    @endif
@endif
<div class="row">
    <div class="col-md-6">
        <h3>Customer information</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <td>{{ $auth->name }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $auth->phone }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $auth->address }}</td>
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-md-6">
        <h3>Delivery information</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <td>{{ $order->name }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $order->address }}</td>
                </tr>
            </thead>
        </table>
    </div>
</div>
<h3>Product information</h3>
<table class="table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Image</th>
            <th>Product name</th>
            <th>Product quantity</th>
            <th>Product price</th>
            <th>Sub total</th>
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