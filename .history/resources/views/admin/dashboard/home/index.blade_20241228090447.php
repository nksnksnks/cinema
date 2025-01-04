@extends('admin.dashboard.layout')

@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Monthly</span>
                    <h5>Tổng doanh thu</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{ number_format($monthlyRevenue, 0, ',', '.') }} VNĐ</h1>
                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                    <small>Total Revenue</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Monthly</span>
                    <h5>Tổng số vé</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$monthlyTickets}}</h1>
                    <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                    <small>New ticket</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Monthly</span>
                    <h5>Phim được xem nhiều</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$mostWatchedMovieInMonth}}</h1>
                    <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                    <small>New movie</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Monthly</span>
                    <h5>Account New</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$NewUsersThisMonth}}</h1>
                    <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                    <small>In first month</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h5>Thống kê doanh thu</h5>
                    <div class="pull-right">
                        <div class="btn-group" id="ajax">
                            <form action="{{route('thongke.index')}}" method="GET">
                                <div class="row">
                                    @php
                                        if(Auth::user()->role_id == 1){
                                            $s = 3;
                                        }else{
                                            $s = 4;
                                        }
                                    @endphp
                                    @if(Auth::user()->role_id == 1)
                                        <div class="col-md-{{$s}}">
                                            @php
                                                $user = Auth::user()->id;
                                                $acc = App\Models\Account::find($user);
                                                $cinemas = App\Models\Cinema::all();
                                            @endphp
                                            <select class="form-control select-cinema" data-account-id="{{ $acc->id }}">
                                                <option>Tất cả chi nhánh</option>
                                                @foreach($cinemas as $cinema)
                                                    <option name="cinema_id" value="{{ $cinema->id }}"
                                                        {{ $acc->cinema_id == $cinema->id ? 'selected' : '' }}>
                                                        {{ $cinema->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-md-{{$s}}">
                                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $startDate ?? '') }}">
                                    </div>
                                    <div class="col-md-{{$s}}">
                                        
                                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $endDate1 ?? '') }}">
                                    </div>
                                    <div class="col-md-{{$s}}">
                                        <button class="btn btn-primary">Lọc</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <canvas id="myChart"></canvas>
                            {{-- <p style="text-align: center; margin-top: 10px;">Biểu đồ thể hiện tổng doanh thu của Cinema</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
     $(document).ready(function() {
        const statisticsData = @json($statistics);
        console.log(statisticsData);

        // Lấy dữ liệu cho biểu đồ
        const labels = statisticsData.map(stat => stat.date); // Ngày tháng
        const totalRevenue = statisticsData.map(stat => stat.total_revenue); // Tổng doanh thu

        // Dữ liệu cho biểu đồ đường
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Tổng doanh thu',
                    data: totalRevenue,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.4 // Làm mịn đường biểu đồ
                }
            ]
        };

        // Cấu hình biểu đồ
        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Biểu đồ Thống kê Doanh thu theo Thời gian',
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                            }
                        }
                    }
                }
            }
        };

        // Vẽ biểu đồ
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );


        // Sử dụng event delegation để lắng nghe sự thay đổi của danh mục
        $('#ajax').on('change', '.select-cinema', function() {
            var accId = $(this).data('account-id');
            var cinemaId = $(this).val();

            $.ajax({
                url: '{{ route('account.update', '') }}/' + accId,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    cinema_id: cinemaId
                },
                success: function(response) {
                    // alert('Trạng thái đã được cập nhật thành công');
                },
                error: function(xhr) {
                    alert('Đã xảy ra lỗi khi cập nhật danh mục');
                }
            });
        });
    });
  
</script>