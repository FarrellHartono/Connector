<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminApprovalView()
    {
        $businesses = Business::where('status', 0)->get();
        $declinedBusinesses = Business::where('status', 2)->get();
        return view('approvalAdmin', compact('businesses', 'declinedBusinesses'));
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

    public function delete($id)
    {

        $business = Business::findOrFail($id);
        // Correct way to handle image deletion
        if ($business->image_path) {
            // Construct the full path using storage_path
            $fullImagePath = storage_path('app' . $business->image_path);
            
            // Add some logging or debugging
            \Log::info('Attempting to delete image', [
                'business_id' => $id,
                'image_path' => $business->image_path,
                'full_path' => $fullImagePath,
                'file_exists' => File::exists($fullImagePath)
            ]);

            // Check if the file exists and delete it
            if (File::exists($fullImagePath)) {
                File::deleteDirectory($fullImagePath);
            }
        }

        // Delete business from database
        $business->delete();

        return redirect()->route('admin.businesses')
            ->with('success', 'Business and associated image deleted successfully.');
    }
}
