<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Business;
use Illuminate\Support\Facades\Auth;

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
}
