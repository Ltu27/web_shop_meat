@extends('master.admin')
@section('title', 'Danh sách đơn hàng')

@section('main')
    <div class="table-responsive">
        <div class="container">
            <div class="row mb-3 gx-2 gy-2 align-items-end">
                <div class="col-md-2">
                    <label for="filter-status" class="form-label">Trạng thái:</label>
                    <select id="filter-status" class="form-control form-control-sm">
                        <option value="">Tất cả</option>
                        <option value="0">Chờ xác nhận</option>
                        <option value="1">Đã xác nhận</option>
                        <option value="2">Chưa thanh toán</option>
                        <option value="3">Đã thanh toán</option>
                        <option value="4">Đã nhận hàng</option>
                        <option value="6">Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="from-date" class="form-label">Từ ngày:</label>
                    <input type="date" id="from-date" class="form-control form-control-sm" />
                </div>
                
                <div class="col-md-2">
                    <label for="to-date" class="form-label">Đến ngày:</label>
                    <input type="date" id="to-date" class="form-control form-control-sm" />
                </div>

                <div class="col-md-1" style="margin-top: 26px">
                    <button id="filter-date-btn" class="btn btn-primary btn-sm">Lọc</button>
                </div>
    
                {{-- <div class="col-md-2 align-self-end">
                    <label for="search-keyword" class="form-label">Tìm kiếm:</label>
                    <input type="text" id="search-keyword" class="form-control form-control-sm" placeholder="Nhập từ khóa..." />
                </div> --}}
                
                
            </div>        
        </div>
        
        <table class="table table-bordered" id="order-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
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
        let table = $('#order-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{ route("order.getListOrder") }}',
                data: function(d) {
                    d.filters = {};
                    const status = $('#filter-status').val();
                    if (status) {
                        d.filters.status = status;
                    }

                    const from = $('#from-date').val();
                    const to = $('#to-date').val();

                    if (from) d.from = from;
                    if (to) d.to = to;
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'customer_name', name: 'customer_name' },
                { data: 'product_name', name: 'product_name' },
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

        $('#filter-status, #filter-date-btn').change(function() {
            table.ajax.reload();
        });
        $('#filter-date-btn').on('click', function() {
            table.ajax.reload();
        });
    });

</script>

@endsection