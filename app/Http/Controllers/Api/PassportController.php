<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller {
	public $successStatus = 200;
	public $errorStatus = 401;

	/**
	 * Register
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  name email password c_password
	 * @return \Illuminate\Http\Response
	 */

	public function register( Request $request ) {
		$validator = Validator::make( $request->all(), [
			'name'       => 'required',
			'email'      => 'required|email',
			'password'   => 'required',
			'c_password' => 'required|same:password',
		] );

		if ( $validator->fails() ) {
			return response()->json( [ 'error' => $validator->errors() ], $this->errorStatus );
		}

		$input             = $request->all();
		$input['password'] = bcrypt( $input['password'] );
		$user              = User::create( $input );
		$success['token']  = $user->createToken( 'MyApp' )->accessToken;
		$success['name']   = $user->name;

		return response()->json( [ 'success' => $success ], $this->successStatus );

	}

	/**
	 * Login
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  email password
	 * @return \Illuminate\Http\Response
	 */

	public function login() {
		if ( Auth::attempt( [ 'email' => request( 'email' ), 'password' => request( 'password' ) ] ) ) {
			$user             = Auth::user();
			$success['token'] = $user->createToken( 'MyApp' )->accessToken;
			$success['message'] = 'Success!!!';

			return response()->json( [ 'success' => $success ], $this->successStatus );

		} else {
			return response()->json( [ 'error' => 'Unauthorised' ], $this->errorStatus );
		}
	}

	/**
	 * Get details
	 *
	 * @param token
	 * @return \Illuminate\Http\Response
	 */
	public function getDetails()
	{
		$user = Auth::user();
		return response()->json(['success' => $user], $this->successStatus);
    }

	/**
	 * logout
	 *
	 * @param token
	 * @return \Illuminate\Http\Response
	 */
    public function logout(){
		Auth::logout();
		return response()->json(['success' => 'You are logined out'], $this->successStatus);
	}


}
