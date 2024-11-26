<!-- resources/views/auth/forgot-password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Quên Mật Khẩu</title>
</head>
<body>
    <h1>Quên Mật Khẩu</h1>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        @error('email')
            <div>{{ $message }}</div>
        @enderror
        <button type="submit">Gửi OTP</button>
    </form>
</body>
</html>
