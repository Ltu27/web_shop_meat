@extends('master.admin')
@section('title', 'Order list')

@section('main')
    
    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $item)
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
                        <a href="{{ route('order.show', $item->id) }}" class="btn btn-sm btn-primary">Chi tiết</a>
                    </td>
                </tr>
            @endforeach
            
        </tbody>
    </table>

@endsection