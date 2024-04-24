@extends("layouts.auth")

@section("content")
	<div class="login-box">
		<div class="login-logo">
			<a href="#" style="color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">ヤフカリ</a>
		</div>

		@if ($errors->any())
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<span class="alert-text text-white"> {{__('messages.auth.email_or_password_error')}} </span>
				<button type="button" class="close" data-dismiss="alert" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif

		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">{{__('messages.auth.login_welcome')}}</p>
				
				{{ isset($error) ? $error : '' }}
				<form method="POST" action="{{ route('login') }}" role="form" class="text-start">
					<div class="input-group mb-3">
					@csrf
						<input type="email" class="form-control" placeholder="Email" name="email">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
						@error('email')
							<small class="text-danger text-xs">{{ $message }}</small>
						@enderror
					</div>
					<div class="input-group mb-3 ">
						<input type="password" id="password" class="form-control" placeholder="{{__('messages.profile.password')}}" name="password">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock" id="pass-show"></span>
							</div>
						</div>
						@error('password')
							<small class="text-danger text-xs">{{ $message }}</small>
						@enderror
					</div>
					<p class="mb-1 text-xs rt">
						<a href="{{ route('forgot') }}">{{__('messages.auth.forget_password')}}</a>
					</p>
					<div class="row">
						<div class="col-8">
							<!-- <div class="icheck-primary">
								<input type="checkbox" id="remember">
								<label for="remember">
									Remember Me
								</label>
							</div> -->
						</div>
					<!-- /.col -->
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary btn-block">{{__('messages.auth.login')}}</button>
						</div>
					<!-- /.col -->
					</div>
				</form>

				<!-- <div class="social-auth-links text-center mb-3">
					<p>- OR -</p>
					<a href="#" class="btn btn-block btn-primary">
					<i class="fab fa-facebook mr-2"></i> {{__('messages.auth.login_fb')}}
					</a>
					<a href="#" class="btn btn-block btn-danger">
					<i class="fab fa-google-plus mr-2"></i> {{__('messages.auth.login_go')}}
					</a>
				</div> -->
				<!-- /.social-auth-links -->                
				<p class="mb-0 text-xs">
					<a href="{{  url('/register') }}">{{__('messages.auth.have_no_account')}}</a>
				</p>
			</div>
			<!-- /.login-card-body -->
		</div>
		
	</div>
@endsection

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<script>
	$(document).ready(function() {        
		$("#pass-show").on('click', function(event) {

			event.preventDefault();
			if($('#password').attr("type") == "text"){
				$('#password').attr('type', 'password');
				$('#pass-show').removeClass( "fas fa-unlock" );
				$('#pass-show').addClass("fas fa-lock"); 
			}else if($('#password').attr("type") == "password"){
				$('#password').attr('type', 'text');
				$('#pass-show').removeClass( "fas fa-lock" );
				$('#pass-show').addClass("fas fa-unlock");  
			}
		});
	});
</script>
