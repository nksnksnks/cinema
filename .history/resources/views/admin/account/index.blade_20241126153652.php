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
        <th class="text-center">Role</th>
        <th class="text-center">Chi nhánh</th>
        <th class="text-center">Status</th>
        <th class="text-center">Manager</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($accounts) && $accounts->isNotEmpty())
        @foreach($accounts as $acc)
    <tr>
        <td>
            <input type="checkbox" value="{{ $acc->id }}" class="input-checkbox checkBoxItem">
        </td>
        <td>
            {{ $acc->username }}
        </td>
        <td>
            {{ $acc->email }}
        </td>       
        <td>
            <select class="form-control select-role" data-account-id="{{ $acc->id }}">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" 
                        {{ $acc->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-control select-cenima" data-account-id="{{ $acc->id }}">
                @foreach($cinemas as $cinema)
                    <option value="{{ $cinema->id }}" 
                        {{ $acc->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-control select-role" data-account-id="{{ $acc->id }}">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" 
                        {{ $acc->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-control select-status" data-account-id="{{ $acc->id }}">
                <option value="1" {{ $acc->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ $acc->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </td>
        <td class="text-center">
            <form action="{{ route('account.destroy', $acc->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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
        var accId = $(this).data('account-id');
        var status = $(this).val();

        $.ajax({
            url: '{{ route('account.update', '') }}/' + accId,
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
    $('#table-movie').on('change', '.select-role', function() {
        var accId = $(this).data('account-id');
        var roleId = $(this).val();

        $.ajax({
            url: '{{ route('account.update', '') }}/' + accId,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                role_id: roleId
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