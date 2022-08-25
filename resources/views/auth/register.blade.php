<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('assets/auth/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/css/main.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('assets/auth/images/img-01.png') }}" alt="IMG">
				</div>

                <form class="user" action="{{ route('auth.register') }}" method="post">
                    @csrf
					<span class="login100-form-title">
						Register
					</span>
                    
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                    </div>
                    @endif
                    @if (session()->has('login_error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('login_error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                    </div>
                    @endif

                    @error('name')
                    <span class="text-danger ml-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="name" placeholder="Masukkan Nama" autofocus value="{{ old('name') }}">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true" @error('name') style="color: red;" @enderror></i>
                        </span>
                    </div>

                    @error('email')
                    <span class="text-danger ml-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
					<div class="wrap-input100">
						<input class="input100" type="text" name="email" placeholder="Email" autofocus value="{{ old('email') }}">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true" @error('email') style="color: red;" @enderror></i>
						</span>
					</div>

                    @error('password')
                    <span class="text-danger ml-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
					<div class="wrap-input100">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true" @error('password') style="color: red;" @enderror></i>
						</span>
					</div>

                    <div class="wrap-input100">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Confirmation Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true" @error('password') style="color: red;" @enderror></i>
                        </span>
                    </div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Do you have an account?
						</span>
						<a class="txt2" href="{{ route('auth.login') }}">
                            Sign In
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="{{ route('auth.login') }}">
							Login
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{ asset('assets/auth/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/auth/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('assets/auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/auth/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/auth/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/auth/js/main.js') }}"></script>

</body>
</html>