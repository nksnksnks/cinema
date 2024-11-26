@extends('admin.dashboard.layout')
@section('content')

@php
    if ($config['method'] == 'create') {
        $url = route('weeklyticketprice.store');
        $title = 'Thêm mới weeklyticketprice';
        $year = null; // Đảm bảo biến $year không được sử dụng trong chế độ tạo mới
        $method = 'POST';
    } else {
        $url = route('weeklyticketprice.update', $weeklyticketprice->id);
        $title = 'Cập nhật weeklyticketprice';
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
                    <div class="panel-title">Thông tin phí các ngày trong tuần</div>
                    <div class="panel-description">
                        <p>Nhập thông tin của phí ngày mới</p>
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
                                    <label for="day_type" class="control-label text-left">Day_Type <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="day_type"
                                        id="day_type"
                                        value="{{ old('day_type', $weeklyticketprice->day_type ?? '') }}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                    >
                                    @if($errors->has('day_type'))
                                        <p class="error-message">* {{ $errors->first('day_type') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">    
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="description" class="control-label text-left">Description</label>
                                    <textarea 
                                        type="text"
                                        name="description"
                                        id="description"
                                        
                                        class="form-control"
                                        placeholder="Nhập mô tả danh mục"
                                        autocomplete="off"
                                        stlye = "resize: none;"
                                        rows = "6"
                                    >{{ old('description', $weeklyticketprice->description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="special_day" class="control-label text-left">weeklyticketprice <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="date"
                                        name="special_day"
                                        id="special_day"
                                        value="{{ old('special_day', $weeklyticketprice->special_day ?? '') }}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                    >
                                    @if($errors->has('special_day'))
                                        <p class="error-message">* {{ $errors->first('special_day') }}</p>
                                    @endif
                                </div>
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
                                        value="{{ old('extra_fee', $weeklyticketprice->extra_fee ?? '') }}"
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