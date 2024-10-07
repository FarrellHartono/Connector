<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    public function login(){
        return view('login');
    }

    public function loginProcess(Request $request){
        $request->validate([
            "email" => "required|email",
            "password"=>"required"
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($data)){
            return redirect(route('home'));
        }else{
            return redirect(route('register'));
        }
    }
    
    public function register(){
        return view('register');
    }

    public function registerProcess(Request $request){
        $request->validate([
            'name'=> 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sucess', 'Logged out Succesfully!');
    }

}
