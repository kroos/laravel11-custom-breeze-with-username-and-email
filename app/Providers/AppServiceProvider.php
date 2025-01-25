<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// extension for auth
use App\Extensions\Auth\EloquentUserProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;

use App\Models\Login;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		///////////////////////////////////////////////////////////////////////////////////////////
		Auth::provider('loginuserprovider', function (Application $app, array $config) {
			// Return an instance of Illuminate\Contracts\Auth\UserProvider...
			return new EloquentUserProvider($app['hash'], $config['model']);
		});

		///////////////////////////////////////////////////////////////////////////////////////////
		// for reset password token remove the username or email input
		// https://laravel.com/docs/11.x/passwords#resetting-the-password
		// ResetPassword::createUrlUsing(function (User $user, string $token) {
		ResetPassword::createUrlUsing(function (Login $login, string $token) {
				// return 'https://example.com/reset-password?token='.$token;
				return url('reset-password', ['token' => $token]);
		});
	}
}
