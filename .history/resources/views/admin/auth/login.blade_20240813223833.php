<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSPINIA | Login</title>
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="template/css/animate.css" rel="stylesheet">
    <link href="template/css/style.css" rel="stylesheet">
    <link href="template/css/customize.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">IN+</h1>
            </div>
            <h3>Welcome to IN+</h3>
            <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.</p>
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" value={{old('username')}}>
                    @if($errors->has('username'))
                            <p class="error-message">* {{$errors->first('username')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" >
                    @if($errors->has('password'))
                            <p class="error-message">* {{$errors->first('password')}}</p>
                        @endif
                </div>
                @if ($errors->has('login'))
                    <p class="error1">{{ $errors->first('login') }}</p>
                @endif
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <a href="{{route('password.request')}}"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('auth.register') }}">Create an account</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="template/js/jquery-3.1.1.min.js"></script>
    <script src="template/js/bootstrap.min.js"></script>
    
</body>
</html>
