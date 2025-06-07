@extends('master.admin')
@section('title', 'Trang chủ')
@section('main')
{{-- <div class="container mt-5">
    <h4>Biểu đồ sản lượng</h4>
    <canvas id="myChart" width="400" height="200"></canvas>
</div> --}}
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
          <a href="#" class="small-box-footer">Thông tin thêm <i class="fa fa-arrow-circle-right"></i></a>
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
          <a href="#" class="small-box-footer">Thông tin thêm <i class="fa fa-arrow-circle-right"></i></a>
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
          <a href="#" class="small-box-footer">Thông tin thêm <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>

@endsection
@section('js')
<script>
    $(document).ready(function () {
        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar', // hoặc 'line', 'pie', 'doughnut', v.v.
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4'],
                datasets: [{
                    label: 'Sản lượng (tấn)',
                    data: [12, 19, 3, 5],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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
    });
</script>
@endsection