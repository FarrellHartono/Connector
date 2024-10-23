<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class meetingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'business_id' => 'required|exists:businesses,id'
        ]);
    
        // Create a new meeting
        Meeting::create([
            'date' => $data['date'],
            'title' => $data['title'],
            'description' => $data['description'],
            'business_id' => $data['business_id']
        ]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Meeting added successfully!',
            'meeting' => $meeting
        ], 200);
    }

}
