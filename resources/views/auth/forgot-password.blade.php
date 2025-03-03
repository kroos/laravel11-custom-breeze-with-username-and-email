@extends('layouts.app')

@section('content')
<div class="col-sm-12 d-flex flex-column align-items-center justify-content-center">
	<h3>Forgot your password? No problem. Just let us know your username and we will email you a password reset link that will allow you to choose a new one.</h3>
	<form method="POST" action="{{ route('password.email') }}" id="form" class="needs-validation">
		@csrf

		<div class="form-group row m-2">
			<label for="usermail" class="col-sm-4 col-form-label col-form-label-sm">Username/Email : </label>
			<div class="col-sm-8">
				<input type="text" name="input_type" id="usermail" value="{{ old('input_type') }}" class="form-control form-control-sm @error('username') is-invalid @enderror @error('email') is-invalid @enderror" placeholder="Username/Email">
				@error('username') <div class="invalid-feedback fw-lighter">{{ $message }}</div> @enderror
				@error('email') <div class="invalid-feedback fw-lighter">{{ $message }}</div> @enderror
			</div>
		</div>

		<div class="text-center m-0">
			<button type="submit" class="btn btn-sm btn-primary m-3">
				{{ __('Password Reset Link') }}
			</button>
		</div>
	</form>
</div>
@endsection

@section('js')
@endsection
