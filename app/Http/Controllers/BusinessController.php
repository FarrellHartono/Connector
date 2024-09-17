<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    public function upload(Request $request)
    {
        
        $request->validate([
            'title' => 'required|max:50|unique:business',
            'description' => 'required|max:255',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

       
        $fileName = $request->title . '.' . $request->file('file')->getClientOriginalExtension();
        $filePath = $request->file('file')->storeAs('/public/assets/business', $fileName);

        
        $businesses = Business::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $filePath, 
        ]);

        return redirect()->route('home')->with('success', 'Business created successfully!');
    }

    public function uploadPage(){
        return view('create');
    }

    public function home(){
        $businesses = Business::all();
        return view('home', compact('businesses'));
    }
}
