@extends('admin.dashboard.layout')
@section('content')

@php
    if ($config['method'] == 'create')
        $url = route('account.store');
        $title = 'Thêm mới danh mục';
        $account = null; // Đảm bảo biến $account không được sử dụng trong chế độ tạo mới
        $method = 'POST';
    
@endphp

@include('admin.dashboard.component.breadcrumb', ['title' => $title])
    <form action="{{$url}}" method="POST">
    @csrf
    @method($method)
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin tài khoản</div>
                    <div class="panel-description">
                        <p>Nhập thông tin của tài khoản mới</p>
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
                                    <label for="name" class="control-label text-left">UserName <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="username"
                                        id="username"
                                        value="{{ old('name', $account->username ?? '') }}"
                                        class="form-control"
                                        placeholder="Nhập tên tài khoản"
                                        autocomplete="off"
                                       
                                    >
                                    @if($errors->has('username'))
                                        <p class="error-message">* {{ $errors->first('username') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="name" class="control-label text-left">Email <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email', $account->email ?? '') }}"
                                        class="form-control"
                                        placeholder="Nhập email"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('email'))
                                        <p class="error-message">* {{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="name" class="control-label text-left">Password <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="password"
                                        name="password"
                                        id="password"
                                        value="{{ old('password', $account->password ?? '') }}"
                                        class="form-control"
                                        placeholder="Nhập password"
                                        autocomplete="off"
                                    >
                                    @if($errors->has('password'))
                                        <p class="error-message">* {{ $errors->first('password') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Cinema ID -->
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="cinema_id" class="control-label text-left">Chi nhánh (Cinema ID) <span class="text-danger">(*)</span></label>
                                    <select name="cinema_id" id="cinema_id" class="form-control">
                                        @foreach($cinemas as $key => $value)
                                            <option value="{{ $key }}" {{ isset($account) && $account->cinema_id == $key ? 'selected' : '' }}>
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
                                    <label for="role_id" class="control-label text-left">Quyền Role <span class="text-danger">(*)</span></label>
                                    <select name="cinema_id" id="cinema_id" class="form-control">
                                        @foreach($cinemas as $key => $value)
                                            <option value="{{ $key }}" {{ isset($account) && $account->cinema_id == $key ? 'selected' : '' }}>
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
                                    <label for="status" class="control-label text-left">Active</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ isset($account) && $account->status == '1' ? 'selected' : '' }}>Hiển thị</option>
                                        <option value="0" {{ isset($account) && $account->status == '0' ? 'selected' : '' }}>Không</option>
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