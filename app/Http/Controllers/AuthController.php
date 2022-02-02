<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
class AuthController extends Controller
{
    public function register(Request $request){
        $fields=$request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);
        $user=User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
             'password'=>bcrypt($fields['password'])
        ]);
        $token=$user->createToken('myapptoken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
    }

    public function login(Request $request)
        {
        if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
        'message' => 'Invalid login details'
                ], 401);
            }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
                'message' => 'You are successfully logged in',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user details' => $user,
        ]);
        }

    public function logout(Request $request){
        //auth()->user()->tokens()->logout();
        auth()->user()->currentAccessToken()->delete();
        return [
            'message'=>'Logged out'
        ];
    }
}
