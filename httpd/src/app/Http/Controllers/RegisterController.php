<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\User;

class RegisterController extends Controller
{

    
    protected function index(Request $request)
    {

        $data = $request->only(['name','last_name','email','password','password_confirmation']);
        

        Validator::make($data, [ 
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',   
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',

        ])->validate();



        $user = User::create([
            'name' => $request->name, 
            'last_name' => $request->last_name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'email_verified_at' => Now()
        ]);

        if ($user) {
            return response('Created', 201);
        } else {
            return response()->json(['error' => 'Unauthorized'], 500);
        }

    }
}
