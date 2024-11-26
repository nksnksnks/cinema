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
        <th class="text-center">Extra_fee</th>
        <th class="text-center">Manager</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($seattypes) && $seattypes->isNotEmpty())
        @foreach($seattypes as $gen)
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
        <td>
            {{ $gen->extra_fee }}
        </td>
        
        <td class="text-center">
            <a href="{{ route('seattype.edit', $gen->id) }}" class="btn btn-success" ><i class="fa fa-edit"></i></a>
            <form action="{{ route('seattype.destroy', $gen->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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