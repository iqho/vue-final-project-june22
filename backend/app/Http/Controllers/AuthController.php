<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
       // return response()->json(['user' => $request->all()]);
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'confirmPassword' => 'required|string|same:password|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['isSuccessStatus'=>false, 'errors'=>$validator->errors()]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact_number' => $request->contact_number,
            'parmanent_address' => $request->parmanent_address,
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user,'token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json(['isSuccessStatus'=>false, 'errors'=> 'Email and Password doesn\'t Match ! Please Check Email and Password !']);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token, 'token_type' => 'Bearer', ]);
    }
}
