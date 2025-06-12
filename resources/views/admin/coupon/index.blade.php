@extends('master.admin')
@section('title', 'Danh sách phiếu giảm giá')

@section('main')
    <div class="table-responsive">
        <a href="{{ route('coupon.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Thêm mới</a>
        <table class="table table-bordered" id="order-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã giảm giá</th>
                    <th>Giảm giá</th>
                    <th>Ngày hết hạn</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection 
@section('js')
<script>
    $(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const statusFilter = urlParams.get('filters[status]');

        $('#order-table').DataTable({
            processing: true,
            serverSide: true,
            // searchable: false
            ajax: {
                url: '{{ route("coupon.getListCoupon") }}',
                // data: function(d) {
                //     if (statusFilter !== null) {
                //         d.filters = {
                //             status: statusFilter
                //         };
                //     }
                // }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'code', name: 'code' },
                { 
                    data: 'discount', 
                    name: 'discount', 
                    render: function (data) {
                        return parseInt(data) + ' %';
                    }
                },
                { data: 'end_date', name: 'end_date' },
                { data: 'quantity', name: 'quantity' },
                { data: 'status', name: 'status' },
                { data: 'id', 
                    name: 'action', 
                    orderable: false, 
                    className: 'text-center',
                    render: function(data) {
                        var editUrl = '{{ route("coupon.edit", ":id") }}'.replace(':id', data);
                        var deleteUrl = '{{ route("coupon.destroy", ":id") }}'.replace(':id', data);
                        var csrf = '{{ csrf_token() }}';

                        return `
                            <div class="d-flex justify-content-center align-items-center flex-nowrap">
                                <a href="${editUrl}" class="btn btn-sm btn-primary m-1"><i class="fa fa-edit"></i> Sửa</a>
                                <form method="POST" action="${deleteUrl}" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    <input type="hidden" name="_token" value="${csrf}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger m-1"><i class="fa fa-trash"></i> Xóa</button>
                                </form>
                            </div>
                        `;
                    }
                }
            ]
        });
    });
</script>

@endsection