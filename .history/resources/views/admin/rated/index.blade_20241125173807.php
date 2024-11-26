@extends('admin.dashboard.layout')
@section('content')
<table class="table table-striped table-bordered" id="table-movie">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th class="text-center">Name</th>
       
        <th class="text-center">Description</th>

        <th class="text-center">Manager</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($rateds) && $rateds->isNotEmpty())
        @foreach($rateds as $gen)
    <tr>
        <td>
            <input type="checkbox" value="{{ $gen->id }}" class="input-checkbox checkBoxItem">
        </td>
        <td>
            {{ $gen->name }}
        </td>
        
        <td>
            {{ $gen->description }}
        </td>
        
        <td class="text-center">
            <a href="{{ route('rated.edit', $gen->id) }}" class="btn btn-success" ><i class="fa fa-edit"></i></a>
            <form action="{{ route('rated.destroy', $gen->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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
@endsection