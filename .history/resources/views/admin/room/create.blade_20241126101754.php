@extends('admin.dashboard.layout')

@section('content')
@php
    $url = route('room.store'); // Đường dẫn tới API store
    $title = 'Thêm mới phòng';
    $method = 'POST';
@endphp

@include('admin.dashboard.component.breadcrumb', ['title' => $title])

<style>
    .seat-grid {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.seat-grid .row {
    display: flex;
    gap: 10px;
}

.seat {
    width: 40px;
    height: 40px;
    background-color: #f1f1f1;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 12px;
    transition: background-color 0.3s;
}

.seat.selected {
    background-color: #2d87f0;
    color: white;
}

.seat:hover {
    background-color: #ddd;
}

</style>

<form action="{{ $url }}" method="POST">
    @csrf
    @method($method)
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin phòng chiếu</div>
                    <div class="panel-description">
                        <p>Nhập thông tin của phòng chiếu mới</p>
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <!-- Tên phòng -->
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="name" class="control-label text-left">Tên phòng <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="name"
                                        id="name"
                                        value="{{ old('name') }}"
                                        class="form-control"
                                        placeholder="Nhập tên phòng"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Số hàng và số cột -->
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="row_count" class="control-label text-left">Số hàng <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="number"
                                        name="row_count"
                                        id="row_count"
                                        value="3"
                                        class="form-control"
                                        placeholder="Nhập số hàng"
                                    >
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="column_count" class="control-label text-left">Số cột <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="number"
                                        name="column_count"
                                        id="column_count"
                                        value="4"
                                        class="form-control"
                                        placeholder="Nhập số cột"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Loại ghế mặc định -->
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="default_seat_type" class="control-label text-left">Loại ghế mặc định</label>
                                    <select id="default_seat_type" name="default_seat_type" class="form-control">
                                        <option value="1">Standard</option>
                                        <option value="2">VIP</option>
                                        <option value="3">Couple</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Bản đồ ghế -->
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="seat_map" class="control-label text-left">Bản đồ ghế</label>
                                    <div id="seat-grid" class="seat-grid"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mb15">
                            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
<script>
    // Hàm tạo ghế tự động theo số hàng và cột
    function generateSeats() {
        const rows = document.getElementById('row_count').value;
        const cols = document.getElementById('column_count').value;
        const seatType = document.getElementById('default_seat_type').value;

        const seatMap = [];
        let seatHtml = '';
        for (let i = 0; i < rows; i++) {
            let rowHtml = '<div class="row">';
            for (let j = 0; j < cols; j++) {
                const seatCode = String.fromCharCode(65 + i) + (j + 1); // Tạo mã ghế A1, A2...
                seatHtml += `<div class="seat" data-code="${seatCode}" data-type="${seatType}" onclick="toggleSeatSelection(this)">${seatCode}</div>`;
            }
            seatHtml += '</div>';
        }
        document.getElementById('seat-grid').innerHTML = seatHtml;
    }

    // Hàm thay đổi trạng thái ghế khi click
    function toggleSeatSelection(seat) {
        seat.classList.toggle('selected');
    }

    // Tạo bản đồ ghế khi load trang
    document.addEventListener('DOMContentLoaded', generateSeats);
</script>
@endsection
