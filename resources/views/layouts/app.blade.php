<?php
use \Carbon\Carbon;

$currentYear = Carbon::now()->year;
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="keywords" content="" />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- <title>Laravel11 Boilerplate</title> -->
	<title>{{ config('app.name', 'Laravel') }}</title>

	<link href="" type="image/x-icon" rel="icon" />

	<!-- Styles -->
	<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
	<!-- Bootswatch Cerulean CSS -->
	<link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
	<!-- Livewire CSS -->
	@livewireStyles

</head>

<body class="bg-secondary bg-opacity-75">
	<div class="container-fluid row min-vh-100 align-items-center justify-content-center mx-auto">

		@include('layouts.navbar')
		<div class="col-sm-4 justify-content-center m-0">
			@include('layouts.messages')
		</div>

		<div class="container p-3 row justify-content-center m-0">
			@yield('content')
		</div>

		<div class="container py-3 align-self-end text-center fs-6 text-secondary fw-lighter m-0">
			Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
		</div>
	</div>

</body>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('js/ckeditor/adapters/jquery.js') }}"></script>
<script>
	jQuery.noConflict ();
	(function($){
		$(document).ready(function(){
			@section('js')
			@show
		});
	})(jQuery);
</script>
@livewireScripts
</html>
