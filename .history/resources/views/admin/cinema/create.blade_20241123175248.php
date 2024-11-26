@extends('admin.dashboard.layout')
@section('content')

@php
    if ($config['method'] == 'create') {
        $url = route('cinema.create');
        $title = 'Thêm chi nhánh mới';
        $cenima = null; // Đảm bảo biến $category không được sử dụng trong chế độ tạo mới
        $method = 'POST';
    } else {
        $url = route('category.update', $category->id);
        $title = 'Cập nhật chi nhánh';
        $method = 'POST';
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
                                    <textarea 
                                        type="text"
                                        name="address"
                                        id="address"
                                        class="form-control"
                                        placeholder="Nhập địa chỉ chi nhánh"
                                        autocomplete="off"
                                        stlye = "resize: none;"
                                        rows = "6"
                                    >{{ old('address', $cinema->address ?? '') }}</textarea>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Ngăn trình duyệt load lại trang khi gửi form

            const url = form.action;
            const formData = new FormData(form);

            // Xóa thông báo cũ (nếu có)
            document.querySelectorAll('.alert').forEach(alert => alert.remove());

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === {{ Constant::SUCCESS_CODE }}) {
                    // Hiển thị thông báo thành công
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success';
                    successAlert.textContent = data.message;
                    form.insertAdjacentElement('beforebegin', successAlert);

                    // Tùy chọn: Reset form sau khi lưu thành công
                    form.reset();

                    // Hoặc chuyển hướng (nếu muốn)
                    // window.location.href = '{{ route('cinema.store') }}';
                } else {
                    // Hiển thị thông báo lỗi
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger';
                    errorAlert.textContent = data.message;
                    form.insertAdjacentElement('beforebegin', errorAlert);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger';
                errorAlert.textContent = 'Có lỗi xảy ra. Vui lòng thử lại.';
                form.insertAdjacentElement('beforebegin', errorAlert);
            });
        });
    });
</script>
