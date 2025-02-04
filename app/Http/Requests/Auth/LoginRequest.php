<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginRequest extends FormRequest
{
	protected $inputType;
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'email' => ['required_without:username', 'string', 'email', 'exists:users,email'],
			'username' => ['required_without:email', 'string', 'exists:logins,username'],
			'password' => ['required', 'string'],
		];
	}

	/**
	 * Attempt to authenticate the request's credentials.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function authenticate(): void
	{
		$this->ensureIsNotRateLimited();

		// need to add this for the email login
		if($this->inputType == 'email') {
			// we need to find the username from logins table
			$usern = User::where('email', $this->only($this->inputType))->first()->hasmanylogin->first()->username;
			$this->merge([ 'username' => $usern ]);
		}

		// if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
		if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
			RateLimiter::hit($this->throttleKey());

			throw ValidationException::withMessages([
				// 'email' => trans('auth.failed'),
				'username' => trans('auth.failed'),
			]);
		}

		RateLimiter::clear($this->throttleKey());
	}

	/**
	 * Ensure the login request is not rate limited.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function ensureIsNotRateLimited(): void
	{
		if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
			return;
		}

		event(new Lockout($this));

		$seconds = RateLimiter::availableIn($this->throttleKey());

		throw ValidationException::withMessages([
			// 'email' => trans('auth.throttle', [
			$this->inputType => trans('auth.throttle', [
				'seconds' => $seconds,
				'minutes' => ceil($seconds / 60),
			]),
		]);
	}

	/**
	 * Get the rate limiting throttle key for the request.
	 */
	public function throttleKey(): string
	{
		// return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
		return Str::transliterate(Str::lower($this->string($this->inputType)).'|'.$this->ip());
	}

	protected function prepareForValidation()
	{
		$this->inputType = filter_var($this->input('input_type'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
		$this->merge([ $this->inputType => $this->input('input_type') ]);
		// dd($this->merge([ $this->inputType => $this->input('input_type') ]), $this->inputType, $this->input($this->inputType));
	}
}
