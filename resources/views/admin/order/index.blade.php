@extends('master.admin')
@section('title', 'Danh sách đơn hàng')

@section('main')
    <div class="table-responsive">
        <table class="table table-bordered" id="order-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
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
            ajax: {
                url: '{{ route("order.getListOrder") }}',
                data: function(d) {
                    if (statusFilter !== null) {
                        d.filters = {
                            status: statusFilter
                        };
                    }
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at' },
                { data: 'status', name: 'status' },
                { data: 'total_price', name: 'total_price', render: $.fn.dataTable.render.number(',', '.', 0) },
                { data: 'id', 
                    name: 'action', 
                    orderable: false, 
                    className: 'text-center',
                    render: function(data) {
                        var html = '';
                        html += '<div class="d-flex justify-content-center align-items-center flex-nowrap">';
                        html += '<a href="{{ route("order.show", ":id") }}" class="m-2 btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>';
                        html = html.replace(':id', data);
                        html += '</div>';
                        return html;
                    }
                }
            ]
        });
    });
</script>

@endsection