@extends('admin.dashboard.layout')
@section('content')

@php
    if ($config['method'] == 'create') {
        $url = route('cinema.create');
        $title = 'Thêm chi nhánh mới';
        $cinema = null; // Đảm bảo biến $category không được sử dụng trong chế độ tạo mới
        $method = 'POST';
    } else {
        $url = route('category.update', $category->id);
        $title = 'Cập nhật chi nhánh';
        $method = 'PUT';
    }
@endphp

@include('admin.dashboard.component.breadcrumb', ['title' => $title])
<form action="{{$url}}" method="POST" id="cinema-form">
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
                                    <label for="name" class="control-label text-left">Name <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="name"
                                        id="slug"
                                        value="{{ old('name', $cinema->name ?? '') }}"
                                        class="form-control"
                                        placeholder="Nhập tên danh mục"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('name'))
                                        <p class="error-message">* {{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="address" class="control-label text-left">Address</label>
                                    <input 
                                        type="text"
                                        name="address"
                                        id="address"
                                        class="form-control"
                                        value="{{ old('address', $cinema->address ?? '')}}"
                                        placeholder="Nhập địa chỉ chi nhánh"
                                        autocomplete="off"
                                        style="resize: none;"
                                       
                                    ></input>
                                    @if($errors->has('address'))
                                        <p class="error-message">* {{ $errors->first('address') }}</p>
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

@push('scripts')
<script>
    // Lắng nghe sự kiện submit của form
    document.getElementById('cinema-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Ngừng hành động submit mặc định

        let form = this;
        let formData = new FormData(form);

        // Gửi yêu cầu AJAX
        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                // Thông báo thành công và chuyển hướng
                alert(data.message); // Hiển thị thông báo
                window.location.href = "{{ route('cinema.store') }}"; // Điều hướng tới URL "cinema/store"
            } else {
                // Xử lý nếu có lỗi
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        });
    });
</script>
@endpush
