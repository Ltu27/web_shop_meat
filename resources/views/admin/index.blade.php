@extends('master.admin')
@section('title', 'Trang chủ')
@section('main')
    <div class="row">
      <!-- Tổng sản phẩm -->  
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $totalProducts }}</h3>

            <p>Sản phẩm</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ route('product.index') }}" class="small-box-footer">Thông tin thêm<i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $totalConfirmedOrder }}</h3>

            <p>Đơn đã xác nhận</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ route('order.index', ['filters[status]' => 1]) }}" class="small-box-footer">Thông tin thêm <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ $totalPaidOrder }}</h3>

            <p>Đơn đã thanh toán</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{ route('order.index', ['filters[status]' => 3]) }}" class="small-box-footer">Thông tin thêm <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ $totalCancelOrder }}</h3>

            <p>Đơn đã hủy</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="{{ route('order.index', ['filters[status]' => 6]) }}" class="small-box-footer">Thông tin thêm <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>

    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <div class="box">
          <div class="box-header with-border d-flex justify-content-between align-items-center">
            <h3 class="box-title">Biểu đồ thống kê doanh số</h3>
            <div class="form-inline">
              <select id="filter-type" class="form-select form-select-sm">
                <option value="year">Theo năm</option>
                  <option value="month">Theo tháng</option>
              </select>
              <select id="filter-month" class="form-select form-select-sm mx-2">
                  <!-- Tạo danh sách 12 tháng -->
                  @for ($m = 1; $m <= 12; $m++)
                      <option value="{{ $m }}">{{ $m }}</option>
                  @endfor
              </select>
              <select id="filter-year" class="form-select form-select-sm">
                  <!-- Tạo danh sách 5 năm gần nhất -->
                  @for ($y = date('Y'); $y >= date('Y') - 4; $y--)
                      <option value="{{ $y }}">{{ $y }}</option>
                  @endfor
              </select>
              <button id="btn-filter" class="btn btn-primary btn-sm ms-2">Lọc</button>
          </div>          
          </div>
          <div class="box-body">
            <canvas id="chart-sale" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-lg-6">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Top 10 sản phẩm tồn kho nhiều nhất</h1>
          </div>
          <div class="box-body">
            <ul class="list-group">
              @foreach ($topStockProducts as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  {{ $product->name }}
                  <span class="badge bg-primary">{{ $product->total_stock }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>      
    
      <div class="col-lg-6">
        <div class="box">
          <div class="box-header with-border">
            <h1 class="box-title">Top 10 sản phẩm bán chạy</h1>
          </div>
          <div class="box-body">
            <canvas id="top-sold-chart" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>

    
@endsection
@section('js')
<script>
    let chart;

    function renderChart(labels, data) {
        const ctx = document.getElementById('chart-sale').getContext('2d');
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (nghìn đồng)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.4)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function fetchData(type, value) {
      $.ajax({
          url: "{{ route('admin.chartOrder') }}",
          method: 'GET',
          data: {
              type: type,
              month: (type === 'month') ? $('#filter-month').val() : null,
              year: $('#filter-year').val()
          },
          success: function (res) {
              renderChart(res.labels, res.data);
          }
      });
    }


    $(document).ready(function () {
        $('#btn-filter').click(function () {
            const type = $('#filter-type').val();
            const value = type === 'month' ? $('#filter-month').val() : $('#filter-year').val();
            fetchData(type, value);
        });

        const currentYear = new Date().getFullYear();
        $('#filter-year').val(currentYear);
        fetchData('year', currentYear);

        const soldChart = document.getElementById('top-sold-chart').getContext('2d');
        new Chart(soldChart, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topSellingProducts->pluck('name')) !!},
                datasets: [{
                    label: 'Số lượng bán',
                    data: {!! json_encode($topSellingProducts->pluck('total')) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection