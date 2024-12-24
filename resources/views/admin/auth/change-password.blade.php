@extends('admin.dashboard.layout')
@section('content')

@include('admin.dashboard.component.breadcrumb', ['title' => 'Thay đổi mật khẩu'])
<form action="{{route('auth.change-password')}}" method="POST">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thay đổi mật khẩu</div>
                    <div class="panel-description">
                        <p>Nhập thông tin của mật khẩu mới</p>
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
                                    <label for="current_password" class="control-label text-left">Mật khẩu cũ <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="password"
                                        name="current_password"
                                        class="form-control"
                                        placeholder="Nhập mật khẩu cũ"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('current_password'))
                                        <p class="error-message">* {{ $errors->first('current_password') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="new_password" class="control-label text-left">Mật khẩu mới <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="password"
                                        name="new_password"
                                        class="form-control"
                                        placeholder="Nhập mật khẩu mới"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('new_password'))
                                        <p class="error-message">* {{ $errors->first('new_password') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="new_password_confirmation" class="control-label text-left">Nhập lại mật khẩu mới <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="password"
                                        name="new_password_confirmation"
                                        class="form-control"
                                        placeholder="Nhập lại mật khẩu mới"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('new_password'))
                                        <p class="error-message">* {{ $errors->first('new_password') }}</p>
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


