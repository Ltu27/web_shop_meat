@extends('master.admin')
@section('title', 'Danh sách đơn hàng')

@section('main')
    
    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th>Hành động</th>
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