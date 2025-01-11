<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Business;
use App\Models\Investment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
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

        session(['user_email' => $request->email]);

        if (Auth::attempt($data)) {
            if (!Auth::user()->hasVerifiedEmail()) {
                $request->user()->sendEmailVerificationNotification();
                Auth::logout();
                return redirect('/email/verify');
            }
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
        // Auth::login($user);
        session(['user_email' => $user->email]);

        event(new Registered($user));
        return redirect()->route('verification.notice')->with('successRegister', true);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sucess', 'Logged out Succesfully!');
    }

    public function profile(){
        $investments = Investment::with(['user', 'business'])
                ->select('user_id', 'business_id', DB::raw('SUM(amount) as total_amount'))
                ->groupBy('user_id', 'business_id')
                ->having('user_id', Auth::user()->id)
                ->get();

        return view("profile",  compact('investments'));
    }
}
