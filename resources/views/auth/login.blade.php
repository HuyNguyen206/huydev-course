<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <title>TheSaaS - Register</title>

    <!-- Styles -->
    <link href="assets/css/core.min.css" rel="stylesheet">
    <link href="assets/css/thesaas.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <link rel="icon" href="assets/img/favicon.png">
</head>

<body class="mh-fullscreen bg-img center-vh p-20" style="background-image: url(assets/img/bg-girl.jpg);">




<div class="card card-shadowed p-50 w-400 mb-0" style="max-width: 100%">
    <h5 class="text-uppercase text-center">Login</h5>
    <br><br>
    <form method="post" action="{{url('/login')}}">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Email" value="{{old('email')}}"  class="@error('email') is-invalid @enderror">
            @error('email')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" class="@error('password') is-invalid @enderror">
            @error('password')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="form-group flexbox py-10">
            <label class="custom-control custom-checkbox">
                <input name="remember" type="checkbox" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Remember me</span>
            </label>

            <a class="text-muted hover-primary fs-13" href="#">Forgot password?</a>
        </div>

        <div class="form-group">
            <button class="btn btn-bold btn-block btn-primary" type="submit">
                Login
            </button>
        </div>
    </form>

    <hr class="w-30">

    <p class="text-center text-muted fs-13 mt-20">Already have an account? <a href="{{route('register')}}">Sign in</a></p>
</div>




<!-- Scripts -->
<script src="assets/js/core.min.js"></script>
<script src="assets/js/thesaas.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>
