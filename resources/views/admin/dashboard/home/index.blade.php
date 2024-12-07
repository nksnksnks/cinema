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
                        <div class="btn-group">
                            <form action="{{route('thongke.index')}}" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $startDate ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $endDate ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
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
                        <table class="table table-striped table-bordered" id="table-movie">
                            <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" value="" id="checkAll" class="input-checkbox">
                                </th>
                                <th class="text-center">Ngày</th>
                               
                                <th class="text-center">Tổng doanh thu</th>
                                <th class="text-center">Tổng vé bán được</th>
                                <th class="text-center">Phim được xem nhiều nhất</th>
                              
                            </tr>
                            </thead>
                            <tbody>
                                @if(isset($statistics) && $statistics->isNotEmpty())
                                @foreach ($statistics as $stat)
                                    <tr>
                                        <td>
                                            <input type="checkbox" value="" class="input-checkbox checkBoxItem">
                                        </td>
                                        <td class="text-center">
                                            {{ $stat['date'] }}
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($stat['total_revenue'], 0, ',', '.') }} VNĐ
                                        </td>
                                        <td class="text-center">
                                            {{ $stat['total_tickets'] }}
                                        </td>
                                        <td class="text-center">
                                            {{ $stat['most_watched_movie'] }}
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                                
                        </table>
                    </div>

                    

                </div>
            </div>
        </div>
</div>

@endsection