<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ResponseHandler;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',0
        ]);

        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->response(null, "Invalid credentials", 401);
        }

        $user = JWTAuth::user();
        $data = [
            'user' => $user,
            'authorization' => [
                'token' => $token,
            ]
        ];

        return $this->response($data, "Logged In Successfully", 200);

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response(null, "Error: " . $validator->errors()->toJson(), 400);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
        if ($user) {
            $credentials = ['email' => $request->email, 'password' => $request->password];

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);

            } else {
                $data = [
                    'user' => $user,
                    'authorization' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ];
                return $this->response($data, "Logged In Successfully", 200);
            }

        } else {
            return $this->response(null, "Error Happened", 400);

        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
            ]
        ]);
    }

    public function userDetails()
    {
        $user = JWTAuth::user();
        if ($user) {
            return $this->response($user, "Got User Details", 200);
        } else {
            return $this->response(null, "cannot", 400);

        }
    }

}
