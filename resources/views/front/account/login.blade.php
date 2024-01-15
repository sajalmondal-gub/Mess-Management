<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Mess Management</title>
        <link rel="icon" href="{{ asset('admin-assets/img/2.png') }}" type="image/icon type">
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css') }}">
		<link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
	</head>
	<body class="hold-transition login-page">
            <div class="wrapper">
                <div class="logo">
                    <img src="{{ asset('admin-assets/img/2.png') }}" alt="">
                </div>
                <div class="text-center mt-4 name">
                    Mess Management
                </div>
                @include('admin.message')
                <form class="p-3 mt-3" action="{{ route('account.authenticate') }}" method="post">
                    @csrf
                    <div class="form-field d-flex align-items-center">
                        <span class="far fa-user"></span>
                        <input type="text" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                    </div>
                    <div class="form-field d-flex align-items-center">
                        <span class="fas fa-key"></span>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn mt-3">Login</button>
                </form>
                <div class="text-center fs-6">
                    <a href="#">Forget password?</a> or <a href="#">Sign up</a>
                </div>
            </div>
		<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>		
	</body>
</html>