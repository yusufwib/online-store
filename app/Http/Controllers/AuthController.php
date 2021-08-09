<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use App\Helper\ResponseHelper as JsonHelper;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $res = new JsonHelper;
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $res->responseGet(false, 400, '', $validator->errors());
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return $res->responseGet(false, 401, '', 'Unatorizhed');
        }
        return $res->responseGet(true, 200, [
            'token' => $token
        ], 'Login success.');
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $res = new JsonHelper;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role_id' => 'required',
        ]);

        if($validator->fails()){
            return $res->responseGet(false, 400, '', $validator->errors());
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    [
                        'role_id' => $request->role_id,
                        'password' => bcrypt($request->password),
                    ]
                ));

        return $res->responsePost(true, 201, $user, '');
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        $res = new JsonHelper;

        auth()->logout();
        return $res->responseGet(true, 200, '', 'User successfully signed out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        $res = new JsonHelper;

        return $res->responseGet(true, 200, $this->createNewToken(auth()->refresh()), '');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        $res = new JsonHelper;

        return $res->responseGet(true, 200, auth()->user(), '');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }

}