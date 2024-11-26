@extends('admin.dashboard.layout')
@section('content')
<table class="table table-striped table-bordered" id="table-movie">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th class="text-center">Cinema</th>
        <th class="text-center">Name</th>
        <th class="text-center">Seat_map</th>
        <th class="text-center">Manager</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($rooms) && $rooms->isNotEmpty())
        @foreach($rooms as $room)
    <tr>
        <td>
            <input type="checkbox" value="{{ $room->id }}" class="input-checkbox checkBoxItem">
        </td>
        <td>
            {{ $room->day_type }}
        </td>
        <td>
            {{ $room->description }}
        </td>
        <td> 
            {{ $room->room_day }}
        </td>
        <td>
            {{ $room->extra_fee }}
        </td>
        
        <td class="text-center">
            <a href="{{ route('room.edit', $room->id) }}" class="btn btn-success" ><i class="fa fa-edit"></i></a>
            <form action="{{ route('roomday.destroy', $room->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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