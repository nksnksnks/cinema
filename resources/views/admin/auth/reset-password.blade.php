<!-- resources/views/auth/reset-password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Đặt Lại Mật Khẩu</title>
</head>
<body>
    <h1>Đặt Lại Mật Khẩu</h1>
    <form action="{{ route('password.update', $token)}}" method="POST">
        @csrf
        <div class="input__item">
            <input type="text" name = "email" value="{{$email}}" readonly>
            <span class="icon_mail"></span>
        </div>
        <div class="input__item">
            <input type="password" name="password" placeholder="Password" requied>
            <span class="icon_lock"></span>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <div class="input__item">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" requied>
            <span class="icon_lock"></span>
        </div>
        <button type="submit" class="site-btn">Reset Password</button>
    </form>
</body>
</html>
