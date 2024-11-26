<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Đặt Lại Mật Khẩu</title>
</head>
<body>
    <h1>Đặt Lại Mật Khẩu</h1>
    <form action="{{ route('password.update', $token) }}" method="POST">
        @csrf
        
        <label for="password">Mật Khẩu Mới:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <div>{{ $message }}</div>
        @enderror
        <label for="password_confirmation">Nhập Lại Mật Khẩu:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <button type="submit">Đặt Lại Mật Khẩu</button>
    </form>
</body>
</html>
