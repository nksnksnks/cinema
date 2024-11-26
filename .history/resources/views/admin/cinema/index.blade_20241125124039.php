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
            <th class="text-center">Address</th>
            <th class="text-center">Manager</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($cinema) && $cinema->isNotEmpty())
            @foreach($cinema as $cine)
        <tr>
            <td>
                <input type="checkbox" value="{{ $cine->id }}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                {{ $cine->name }}
            </td>
            <td>
                {{ $cine->address }}
            </td>
       
            
            <td class="text-center">
                <a href="{{ route('cinema.edit', $cine->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <form action="{{ route('cinema.delete', $cine->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
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

    



