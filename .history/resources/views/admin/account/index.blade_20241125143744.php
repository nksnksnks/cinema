@extends('admin.dashboard.layout')
@section('content')
<table class="table table-striped table-bordered" id="table-movie">
    <thead>
    <tr>
        <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th class="text-center">Username</th>
        <th class="text-center">Email</th>
        <th class="text-center">Active/Inactive</th>
        <th class="text-center">Manager</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($accounts) && $accounts->isNotEmpty())
        @foreach($accounts as $acc)
    <tr>
        <td>
            <input type="checkbox" value="{{ $cate->id }}" class="input-checkbox checkBoxItem">
        </td>
        <td>
            {{ $acc->username }}
        </td>
        <td>
            {{-- {{ $category->parent->name ?? ''}} --}}
            {{ $acc->email }}
        </td>       
        
        <td>
            <select class="form-control select-status" data-account-id="{{ $acc->id }}">
                <option value="1" {{ $acc->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ $acc->status == 0 ? 'selected' : '' }}>Không hiển thị</option>
            </select>
        </td>
        <td class="text-center">
            <form action="{{ route('category.destroy', $cate->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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
<script>
    $(document).ready(function() {
    // Sử dụng event delegation để lắng nghe sự thay đổi của danh mục
    $('#table-movie').on('change', '.select-category', function() {
        var movieId = $(this).data('movie-id');
        var categoryId = $(this).val();

        $.ajax({
            url: '{{ route('movie.update', '') }}/' + movieId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                category_id: categoryId
            },
            success: function(response) {
                alert('Danh mục đã được cập nhật thành công');
            },
            error: function(xhr) {
                alert('Đã xảy ra lỗi khi cập nhật danh mục');
            }
        });
    });
</sc