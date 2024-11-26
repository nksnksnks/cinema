@extends('admin.dashboard.layout')
@section('content')

@php
    if ($config['method'] == 'create') {
        $url = route('movie.store');
        $title = 'Thêm mới phim';
        $movie = null; // Đảm bảo biến $genre không được sử dụng trong chế độ tạo mới
        $method = 'POST';
    } else {
        $url = route('movie.update', $movie->id);
        $title = 'Cập nhật phim';
        $method = 'PUT';
    }
@endphp

@include('admin.dashboard.component.breadcrumb', ['title' => $title])
    <form action="{{$url}}" method="POST" enctype = "multipart/form-data" >
    @csrf
    @method($method)
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin phim</div>
                    <div class="panel-description">
                        <p>Nhập thông tin của phim mới</p>
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
                                        value="{{ old('name', $movie->name ?? '') }}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                        onkeyup="ChangeToSlug()"
                                    >
                                    @if($errors->has('name'))
                                        <p class="error-message">* {{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="name" class="control-label text-left">Slug </label>
                                    <input 
                                        type="text"
                                        name="slug"
                                        id="convert_slug"
                                        value="{{ old('name', $movie->slug ?? '') }}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                    >
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
                                        placeholder="..."
                                        autocomplete="off"
                                        stlye = "resize: none;"
                                        rows = "6"
                                    >{{ old('description', $movie->description ?? '') }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="trailer" class="control-label text-left">Trailer</label>
                                    <input 
                                        type="text"
                                        name="trailer_url"
                                        id="trailer_url"
                                        value="{{ old('trailer_url', $movie->trailer_url ?? '') }}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                    >
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="duration" class="control-label text-left">Thời lượng</label>
                                    <input 
                                        type="text"
                                        name="duration"
                                        id="duration"
                                        value="{{ old('duration', $movie->duration ?? '') }}"
                                        class="form-control"
                                        placeholder="..."
                                        autocomplete="off"
                                    >
                                </div>
                            </div>                                       
                        </div>
                        
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="genre_id" class="control-label text-left">Genre</label>
                                    <select name="genre_id[]" id="genre_id" class="form-control select2" multiple="multiple">
                                        @foreach($genre as $key => $value)
                                            <option value="{{ $key }}" 
                                                {{-- Nếu đang ở chế độ edit và genre_id của movie khớp với id thì chọn nó --}}
                                                {{ isset($movie) && $movie->genres->contains($key) ? 'selected' : '' }}>
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
                                    <label for="country_id" class="control-label text-left">Country</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        @foreach($country as $key => $value)
                                            <option value="{{ $key }}" {{ isset($movie) && $movie->country_id == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>
                        </div>
 
                        <div class="row mb15">
                            <div class="col-lg-12">
                                
                                <!-- Input tải ảnh từ máy -->
                                <div class="form-row mt-3" id="upload_image" style="display: none;">
                                    <label for="image" class="control-label text-left">Ảnh đại diện <span class="text-danger">(*)</span></label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    @if(isset($movie))                                   
                                            <img src="{{ $movie->image }}" alt="{{ $movie->name }}" width="100" />
                                       
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            document.getElementById('url_option').addEventListener('click', function() {
                                document.getElementById('url_image').style.display = 'block';
                                document.getElementById('upload_image').style.display = 'none';
                            });
                            document.getElementById('upload_option').addEventListener('click', function() {
                                document.getElementById('url_image').style.display = 'none';
                                document.getElementById('upload_image').style.display = 'block';
                            });
                        </script>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <!-- Input nhập URL ảnh -->
                                <div class="form-row mt-3" id="url_image" >
                                    <label for="poster" class="control-label text-left">URL ảnh poster </label>
                                    <input type="text" 
                                    name="poster" 
                                    id="poster" 
                                    class="form-control" 
                                    placeholder="Nhập URL ảnh"
                                    value="{{ old('poster', $movie->poster ?? '') }}"
                                    >
                                    @if(isset($movie))
                                        <img src="{{ $movie->poster }}" alt="{{ $movie->name }}" width="100" />
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="status" class="control-label text-left">Active</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ isset($movie) && $movie->status == '1' ? 'selected' : '' }}>Hiển thị</option>
                                        <option value="0" {{ isset($movie) && $movie->status == '0' ? 'selected' : '' }}>Không</option>
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

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection