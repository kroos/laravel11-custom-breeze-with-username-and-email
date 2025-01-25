<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
	/**
	* Display the password reset link request view.
	*/
	public function create(): View
	{
		return view('auth.forgot-password');
	}

	/**
	* Handle an incoming password reset link request.
	*
	* @throws \Illuminate\Validation\ValidationException
	*/
	public function store(Request $request): RedirectResponse
	{
		$input_type = filter_var($request->input('input_type'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
		$request->merge([$input_type => $request->input('input_type')]);

		$request->validate([
			'email' => ['required_without:username', 'string', 'email', 'exists:users,email'],
			'username' => ['required_without:email', 'string', 'exists:logins,username'],
		]);


		// need to add this for the email login
		if($input_type == 'email') {
			// we need to find the username from logins table
			$usern = User::where([['email', $request->only($input_type)], ['active', 1]])->first()->hasmanylogin->where('active', 1)->first()->username;
			$request->merge([ 'username' => $usern ]);
		}

		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.
		$status = Password::sendResetLink(
			// $request->only('email')
			$request->only('username')
		);

		return $status == Password::RESET_LINK_SENT
		? back()->with('status', __($status))
		// : back()->withInput($request->only('email'))
		//     ->withErrors(['email' => __($status)]);
		: back()->withInput($request->only('username'))
		->withErrors(['username' => __($status)]);
	}
}
