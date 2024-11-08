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
            return redirect()->back()->with('show_register_confirmation', true)->with('email', $request->email);
            // return redirect(route('register'));
        }
    } 

    public function checkEmail(Request $request) {
        // $email = $request->input('email');
        $email = $request->email;
        error_log("tes") ;
        error_log($email);
        $exists = User::where('email', $email)->exists(); // Cek emailnya udah ada ga
    
        return response()->json(['exists' => $exists]);
    }
    
    public function register(){
        return view('register');
    }

    public function registerProcess(Request $request){
        // (ricky) ini nanti tambah validasi data user

        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "password"=>"required|string|min:8",
            "confirmation_password" => "required|required_with:password|same:password"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password), // Hash password sebelum disimpan
        ]);

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
