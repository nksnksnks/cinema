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
        <th class="text-center">Price</th>
        <th class="text-center">Image</th>
        <th class="text-center">Status</th>
        <th class="text-center">Manager</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($foods) && $foods->isNotEmpty())
        @foreach($foods as $foo)
    <tr>
        <td>
            <input type="checkbox" value="{{ $foo->id }}" class="input-checkbox checkBoxItem">
        </td>
        <td>
            {{ $foo->name }}
        </td>
        <td>
            {{ $foo->description }}
        </td>
        <td>
            {{ $foo->price }}
        </td>
        <td>
            <img src="{{ $foo->image }}" alt="{{ $foo->name }}" width="50" height="50" />
        </td>
        <td>
            <select class="form-control select-status" data-food-id="{{ $foo->id }}">
                <option value="1" {{ $foo->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ $foo->status == 0 ? 'selected' : '' }}>Không hiển thị</option>
            </select>
        </td>
        
        <td class="text-center">
            <a href="{{ route('food.edit', $foo->id) }}" class="btn btn-success" ><i class="fa fa-edit"></i></a>
            <form action="{{ route('food.destroy', $foo->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>

<script>
    $(document).ready(function() {
    // Sử dụng event delegation để lắng nghe sự thay đổi của danh mục
    $('#table-movie').on('change', '.select-status', function() {
        var foodId = $(this).data('food-id');
        var status = $(this).val();

        $.ajax({
            url: '{{ route('food.updateajax', '') }}/' + foodId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                alert('Trạng thái đã được cập nhật thành công');
            },
            error: function(xhr) {
                alert('Đã xảy ra lỗi khi cập nhật danh mục');
            }
        });
    });

});

</script>