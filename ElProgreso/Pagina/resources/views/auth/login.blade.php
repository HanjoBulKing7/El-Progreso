<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>Galletas</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('img/galletas.ico')}}">
	<title>{{ config('app.name', 'Galletas') }}</title>
	<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	
<!--===============================================================================================-->
	<link href="{{ asset('css/bootstrap.css') }} " rel="stylesheet" id="bootstrap-css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/login-nu/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/login-nu/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('/login-nu/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/login-nu/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/login-nu/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/login-nu/css/main.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt">
					<img src="{{ asset('/login-nu/images/img-02.png') }}" alt="IMG">
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
					<span class="login100-form-title">
						Iniciar Sesión
					</span>

					<div class="wrap-input100">
                        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                        
					</div>

					<div class="wrap-input100 ">
                        <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button  type="submit" class="login100-form-btn">
							Inicio
						</button>
                    </div>
                    

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Sistema de Galletas
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	{{-- <script src="{{ asset('/login-nu/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('/login-nu/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('/login-nu/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	{{-- <script src="{{ asset('/login-nu/vendor/select2/select2.min.js') }}"></script> --}}
<!--===============================================================================================-->
	{{-- <script src="{{ asset('/login-nu/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script> --}}
<!--===============================================================================================--> 
	{{-- <script src="{{ asset('/login-nu/js/main.js') }}"></script> --}}

</body>
</html>