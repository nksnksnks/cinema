@extends('admin.dashboard.layout')
@section('content')

@php
    if ($config['method'] == 'create') {
        $url = route('specialday.store');
        $title = 'Thêm mới specialday';
        $year = null; // Đảm bảo biến $year không được sử dụng trong chế độ tạo mới
        $method = 'POST';
    } else {
        $url = route('specialday.update', $specialday->id);
        $title = 'Cập nhật specialday';
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
                    <div class="panel-title">Thông tin danh mục</div>
                    <div class="panel-description">
                        <p>Nhập thông tin của danh mục mới</p>
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
                                    <label for="name" class="control-label text-left">Day_Type <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="day_type"
                                        id="slug"
                                        value="{{ old('day_type', $specialday->day_type ?? '') }}"
                                        class="form-control"
                                        placeholder="Nhập tên loại ngày. VD: New Year, Christmas, ..."
                                        autocomplete="off"
                                        
                                        autofocus
                                    >
                                    @if($errors->has('day_type'))
                                        <p class="error-message">* {{ $errors->first('day_type') }}</p>
                                    @endif
                                </div>
                            </div>
                            
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
                                    >{{ old('description', $specialday->description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-row">
                                <label for="special_day" class="control-label text-left">SpecialDay </label>
                                <input 
                                    type="date"
                                    name="special_day"
                                    id="special_day"
                                    value="{{ old('special_day', $specialday->special_day ?? '') }}"
                                    class="form-control"
                                    placeholder="..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-row">
                                <label for="special_day" class="control-label text-left">SpecialDay </label>
                                <input 
                                    type="date"
                                    name="special_day"
                                    id="special_day"
                                    value="{{ old('special_day', $specialday->special_day ?? '') }}"
                                    class="form-control"
                                    placeholder="..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="status" class="control-label text-left">Active</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ isset($year) && $year->status == '1' ? 'selected' : '' }}>Hiển thị</option>
                                        <option value="0" {{ isset($year) && $year->status == '0' ? 'selected' : '' }}>Không</option>
                                    </select>                                      
                                                                   
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