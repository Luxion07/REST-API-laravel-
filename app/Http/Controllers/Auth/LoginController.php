<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	protected function sendLoginResponse(Request $request)
	{

		$this->clearLoginAttempts($request);

		return response()->json([
			'status' => 'success',
			'redirect' => 0
		]);
	}
	protected function sendFailedLoginResponse(Request $request)
	{
		return response()->json([
			'status' => 'error',
			'redirect' => 0
		]);

	}
	public function logout(Request $request)
	{
		$this->guard()->logout();

		return response()->json([
			'status' => 'logout',
			'redirect' => 0
		]);
	}
}
