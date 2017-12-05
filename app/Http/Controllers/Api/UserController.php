<?php

namespace App\Http\Controllers\Api;


use App\User;
use App\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{

	public $successStatus = 200;
	public $errorStatus = 401;

	/**
	 * Get all users
	 *
	 * @param
	 * @return \Illuminate\Http\Response
	 */

    public function getAll()
    {
		$users = User::all();
		foreach ( $users as $user ) {
			$user['register date'] = $user->created_at->format('d M Y');
		}
		return response()->json($users);
    }


	/**
	 * Get user by id
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  id(Get), token
	 * @return \Illuminate\Http\Response
	 */

	public function getUser(Request $request){

		$search_user_id = User::findOrFail($request->id)->id;
		$count = Like::where('user_to', $search_user_id)->count();
		$user = User::find($search_user_id);
		$success['info'] = $user;
		$success['count of likes'] = $count;


		return response()->json(['success' => $success]);
	}

	/**
	 * Get current user
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  token
	 * @return \Illuminate\Http\Response
	 */

    public function getCurrentUser()
    {
		$user = Auth::user();
		return response()->json(['success' => $user], $this->successStatus);

    }

	/**
	 * Update current user
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  name email password c_password image_source
	 * @return \Illuminate\Http\Response
	 */

	public function updateCurrentUser(Request $request)
	{
		$user = Auth::user();
		$user->name = $request['name'];
		$user->email = $request['email'];

		if ( ! $request['password'] == '')
		{
			$user->password = bcrypt($request['password']);
		}
		$success['message'] = 'User has been updated';
		$success['user-info'] = $user;

		//image edit
		if ( $request->hasFile('image_source')){

			$image = $request->file('image_source');
			$img_ex = $image->getClientOriginalExtension();

			if($user->image_source){
				$user->deleteImage($user->image_source);
			}
			$user->setImage($image, 'image_source', $img_ex);


		}

		//image edit


		$user->save();

		return response()->json(['success' => $success], $this->successStatus);
	}


	/**
	 * Like user by id
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  token, id (Get)
	 * @return \Illuminate\Http\Response
	 */

	public function LikeUser(Request $request) {
		$user = Auth::user();
		$search_user_id = User::findOrFail($request->id);
		$auth_user_id = $user->id;
		$count = Like::where('user_to', $search_user_id->id)->where('user_who', $auth_user_id)->count();

		if($search_user_id->id == $auth_user_id){
			return response()->json(['error' => 'Can not like yourself']);
		}elseif ($count !== 0){
			return response()->json(['success' => 'Like is already isset']);
		}
		if($count == 0){
			$new_like = Like::create(['user_to' => $search_user_id->id, 'user_who' => $auth_user_id]);
			return response()->json(['success' => 'user with id = ' .  $auth_user_id . ' likes user with id = ' .$search_user_id->id]);
		}
		if($search_user_id->id == null){
			return response()->json(['error' => 'No such a user']);
		}



	}

}
