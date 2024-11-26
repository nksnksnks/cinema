@extends('admin.dashboard.layout')
@section('content')

@php
    if ($config['method'] == 'create') {
        $url = route('movieshowtime.store');
        $title = 'Thêm mới movieshowtime';
        $year = null; // Đảm bảo biến $year không được sử dụng trong chế độ tạo mới
        $method = 'POST';
    } else {
        $url = route('movieshowtime.update', $movieshowtime->id);
        $title = 'Cập nhật movieshowtime';
        $method = 'PUT';
    }
@endphp

@include('admin.dashboard.component.breadcrumb', ['title' => $title])
    <form action="{{$url}}" method="POST">
    @csrf
    @method($method)
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin movieshowtime</div>
                    <div class="panel-description">
                        <p>Nhập thông tin của movieshowtime mới</p>
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="movie_id" class="control-label text-left">Movie <span class="text-danger">(*)</span></label>
                                    <select name="movie_id" id="movie_id" class="form-control">
                                        @foreach($movie as $key => $value)
                                            <option value="{{ $key }}" {{ isset($movieshowtime) && $movieshowtime->movie_id == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>
                        </div>

                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="cinema_id" class="control-label text-left">Cinema <span class="text-danger">(*)</span></label>
                                    
                                    <input 
                                        type="text"
                                        value="{{$cinema->name}}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                        readonly
                                    >
                                   
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="room_id" class="control-label text-left">Room <span class="text-danger">(*)</span></label>
                                    <select name="room_id" id="room_id" class="form-control">
                                        @foreach($room as $key => $value)
                                            <option value="{{ $key }}" {{ isset($movieshowtime) && $movieshowtime->room_id == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="start_time" class="control-label text-left">Start_time <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="start_time"
                                        id="start_time"
                                        value="{{ old('start_time', $movieshowtime->start_time ?? '') }}"
                                        class="form-control"
                                        placeholder="08:00:00"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('start_time'))
                                        <p class="error-message">* {{ $errors->first('start_time') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="end_time" class="control-label text-left">End_time <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="end_time"
                                        id="end_time"
                                        value="{{ old('end_time', $movieshowtime->end_time ?? '') }}"
                                        class="form-control"
                                        placeholder="10:00:00"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('end_time'))
                                        <p class="error-message">* {{ $errors->first('end_time') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-row">
                                <label for="date" class="control-label text-left">Ngày khởi chiếu <span class="text-danger">(*)</span></label>
                                <input 
                                    type="date"
                                    name="date"
                                    id="date"
                                    lang="en-CA" 
                                    value="{{ old('date', $movie->date ?? '') }}"
                                    class="form-control"
                                    placeholder="..."
                                    autocomplete="off"
                                >
                                @if($errors->has('date'))
                                    <p class="error-message">* {{ $errors->first('date') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="extra_fee" class="control-label text-left">Extra_fee <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="extra_fee"
                                        id="extra_fee"
                                        value="{{ old('extra_fee', $movieshowtime->extra_fee ?? '') }}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                    >
                                    @if($errors->has('extra_fee'))
                                        <p class="error-message">* {{ $errors->first('extra_fee') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
        </div>
    </div>
</form>


@endsection
