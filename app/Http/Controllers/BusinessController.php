<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Traits\Sortable;

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

    use Sortable;

    public function home(Request $request){
        
        $businesses = Business::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $businesses->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $businesses = $this->applySorting($businesses, $request);
        return view('home', ['businesses' => $businesses->get()]);
       
    }

    public function manage(){
        return view('manageBusiness');
    }
}
