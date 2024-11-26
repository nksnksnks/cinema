@extends('admin.dashboard.layout')
@section('content')
<form action="{{ route('episodes.createAll') }}" method="GET" style="display:inline;" >
    
    <button type="submit" class="btn btn-success">
        Đồng bộ ophim
    </button>
</form> 
<form action="{{ route('episodes.createAllkk') }}" method="GET" style="display:inline;" >
    <button type="submit" class="btn btn-success">
        Đồng bộ kkphim
    </button>
</form> 
<!-- Nút Delete All ở đây -->
<form action="{{ route('movies.destroyMany') }}" method="POST" id="deleteForm" style="display:inline;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="movie_ids" id="movie_ids" value="">
    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa các phim đã chọn?')">
        Delete All
    </button>
    
</form>

<form action="{{ route('movies.destroyAll') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tất cả các phim?');">
    @csrf
    @method('DELETE')
    <button type="submit">Xóa tất cả phim</button>
</form>


{{-- <form action="{{ route('update.poster') }}" method="POST" style="display:inline;" >
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-success">
        poster
    </button>
</form>  --}}
{{-- <a href="javascript:void(0);" class="btn btn-success"  onclick="window.open('{{ route('episodes.createAll') }}', 'newwindow', 'width=800,height=600');">checklink</a> --}}
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="table-movie">
        <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Name</th>
            {{-- <th class="text-center">Description</th> --}}
            {{-- <th class="text-center">Slug</th> --}}
            <th class="text-center">Category</th>
            {{-- <th class="text-center">Genre</th>
            <th class="text-center">Country</th>
            <th class="text-center">Year</th> --}}
            <th class="text-center">Top View</th>
            <th class="text-center">New Comment</th>
            <th class="text-center">Phim Hot</th>
            {{-- <th class="text-center">English Name</th> --}}
            {{-- <th class="text-center">Image</th> --}}
            {{-- <th class="text-center">Quality</th> --}}
            {{-- <th class="text-center">Trailer</th> --}}
            {{-- <th class="text-center">Subtitle</th> --}}
            {{-- <th class="text-center">Tags</th> --}}
            {{-- <th class="text-center">Season</th> --}}
            {{-- <th class="text-center">Duration</th> --}}
            <th class="text-center">Số tập</th>
            <th class="text-center">Thuộc phim</th>
            {{-- <th class="text-center">View Count</th> --}}
            <th class="text-center">Source</th>
            <th class="text-center">Status</th>
            <th class="text-center">Manager</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($movies) && $movies->isNotEmpty())
            @foreach($movies as $mov)
        <tr>
            <td>
                <input type="checkbox" value="{{ $mov->id }}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                {{ $mov->name }}
            </td>
            {{-- <td>
                {{ $mov->description }}
            </td>
            <td>
                {{ $mov->slug }}
            </td> --}}
            
            <td>
                <select class="form-control select-category" data-movie-id="{{ $mov->id }}">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $mov->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </td>
            
            
            
            {{-- <td>
                @foreach($mov->genres as $genre)
                    {{ $genre->name }}
                    @if (!$loop->last), @endif  Thêm dấu phẩy giữa các thể loại, trừ thể loại cuối cùng. 
                @endforeach
            </td> --}}
            {{-- <td>
                {{ $mov->country->name }}
            </td>
            <td>
                {{ $mov->year->name }}
            </td> --}}
            <td>
                <select class="form-control select-topview" data-movie-id="{{ $mov->id }}">
                    <option value="1" {{ $mov->topview == 1 ? 'selected' : '' }}>Có</option>
                    <option value="0" {{ $mov->topview == 0 ? 'selected' : '' }}>Không</option>
                </select>
            </td>
            <td>
                <select class="form-control select-new-comment" data-movie-id="{{ $mov->id }}">
                    <option value="1" {{ $mov->new_comment == 1 ? 'selected' : '' }}>Có</option>
                    <option value="0" {{ $mov->new_comment == 0 ? 'selected' : '' }}>Không</option>
                </select>
            </td>
            <td>
                <select class="form-control select-phim-hot" data-movie-id="{{ $mov->id }}">
                    <option value="1" {{ $mov->phim_hot == 1 ? 'selected' : '' }}>Có</option>
                    <option value="0" {{ $mov->phim_hot == 0 ? 'selected' : '' }}>Không</option>
                </select>
            </td>
            
           
            <td>
              
                {{ $mov->episode->count() .'/'.$mov->sotap }}
            </td>
            <td>
                {{ $mov->thuocphim == 0 ? 'Phim bộ' : 'Phim lẻ' }}
            </td>
            {{-- <td>
                {{ $mov->count_views }}
            </td> --}}
            <td>
                {{ $mov->source }}
            </td>
            <td>
                <select class="form-control select-status" data-movie-id="{{ $mov->id }}">
                    <option value="1" {{ $mov->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ $mov->status == 0 ? 'selected' : '' }}>Không hiển thị</option>
                </select>
            </td>
            
            <td class="text-center">
                <a href="{{ route('movie.edit', $mov->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <form action="{{ route('movie.destroy', $mov->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                <br>
                
                <a href="{{ route('episode.create', $mov->id) }}" class="btn btn-success">Thêm tập phim</i></a>
                {{-- <a href="javascript:void(0);" class="btn btn-success" onclick="window.open('{{ route('movie.show', $mov->slug) }}', 'newwindow', 'width=800,height=600');">Xem thông tin phim</a> --}}
                {{-- @if($mov->thuocphim == 0) --}}
                <form action="{{ route('episodes.createApi', $mov->slug) }}" method="POST" style="display:inline;" >
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-success">
                        Thêm tập ophim
                    </button>
                </form>  
                <form action="{{ route('episodes.createApikk', $mov->slug) }}" method="POST" style="display:inline;" >
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-success">
                        Thêm tập kkphim
                    </button>
                </form>  
                 
                {{-- @endif --}}
                <a href="javascript:void(0);" class="btn btn-success" onclick="window.open('{{ route('movie.show', $mov->slug) }}', 'newwindow', 'width=800,height=600');">checklinkophim</a>
                <a href="javascript:void(0);" class="btn btn-success" onclick="window.open('{{ route('movies.showkk', $mov->slug) }}', 'newwindow', 'width=800,height=600');">checklinkkkphim</a>

            </td>
            
        </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    {{-- {{$movies->links('pagination::bootstrap-4')}} --}}
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>

    



