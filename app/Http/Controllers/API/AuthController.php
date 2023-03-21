<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|String|max:255',
            'email'=>'required|String|max:255',
            'password'=>'required|String|min:8'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $existingUser=User::get()->where('email',$request->email);
        if(count($existingUser)!=0){
            return response()->json(['message'=>'User with this email alredy exists in system!']);
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token=$user->createToken('token')->plainTextToken;

        return response()->json(['user'=>$user,'token'=>$token]);
    }

    public function login(Request $request){
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['mesage'=>'Email or password are wrong!'],401);
        }
        $user=User::where('email',$request->email)->firstOrFail();
        $token=$user->createToken('token')->plainTextToken;

        return response()->json(['message'=>'Welcome '.$user->name,'token'=>$token]);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json('Goodbye.'.'.You successfully logged out!');
    }
}
