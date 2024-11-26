@extends('admin.dashboard.layout')
@section('content')
<table class="table table-striped table-bordered" id="table-movie">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th class="text-center">Slot</th>
        <th class="text-center">Description</th>
        <th class="text-center">timeslot_Day</th>
        <th class="text-center">Extra_fee</th>
        <th class="text-center">Manager</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($timeslotdays) && $timeslotdays->isNotEmpty())
        @foreach($timeslotdays as $timeslot)
    <tr>
        <td>
            <input type="checkbox" value="{{ $timeslot->id }}" class="input-checkbox checkBoxItem">
        </td>
        <td>
            {{ $timeslot->day_type }}
        </td>
        <td>
            {{ $timeslot->description }}
        </td>
        <td> 
            {{ $timeslot->timeslot_day }}
        </td>
        <td>
            {{ $timeslot->extra_fee }}
        </td>
        
        <td class="text-center">
            <a href="{{ route('timeslotday.edit', $timeslot->id) }}" class="btn btn-success" ><i class="fa fa-edit"></i></a>
            <form action="{{ route('timeslotday.destroy', $timeslot->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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