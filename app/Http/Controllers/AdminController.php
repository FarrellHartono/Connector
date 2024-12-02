<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $businesses = Business::where('status', 0)->get();
        return view('approval', compact('businesses'));
    }

    public function approve($id)
    {
        $business = Business::findOrFail($id);
        $business->status = 1; // Approved
        $business->save();

        return redirect()->back()->with('message', 'Business approved successfully!');
    }

    public function decline($id)
    {
        $business = Business::findOrFail($id);
        $business->status = 2; // Declined
        $business->save();

        return redirect()->back()->with('message', 'Business declined successfully!');
    }
}
