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
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(Auth::attempt($data)){
            return redirect(route('home'));
        }else{
            return redirect()->back()->with('show_register_confirmation', true)->with('email', $request->email);
            // return redirect(route('register'));
        }
    }

    public function checkEmail(Request $request) {
        $email = $request->query('email');

        $exists = User::where('email','LIKE', $email)->exists();

        return response($exists ? 'false' : 'true');
    }

    public function register(){
        return view('register');
    }

    public function registerProcess(Request $request){
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password), // Hash password sebelum disimpan
            "phone_number" => $request->phone,
            "dob" => $request->birthDate
        ]);
        error_log("tesssss");
        error_log($user);
        Auth::login($user);

        return redirect(route('home'))->with('successRegister', true);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sucess', 'Logged out Succesfully!');
    }

    public function profile(){
        return view("profile");
    }
}
