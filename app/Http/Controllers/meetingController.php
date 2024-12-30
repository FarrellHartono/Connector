<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Meeting;
use App\Models\RegisteredMeetings;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class MeetingController extends Controller
{
    public function getRegisteredMeetings(Request $request) {

        $upcomingMeetings = Meeting::with('business')
                ->whereHas('business', function ($query) {
                    $query->where('user_id', Auth::id()); // Filter businesses owned by the logged-in user
                })
                ->where('date', '>=', now()) // Filter for upcoming meetings
                ->orderBy('date', 'asc') // Order meetings by date
                ->get()
                ->map(function ($meeting) {
                    return [
                        'title' => $meeting->title,
                        'description' => $meeting->description,
                        'start' => $meeting->date, // Rename 'date' to 'start'
                        'business' => $meeting->business, // Include related business if needed
                    ];
                });
        
        return response()->json(['registered' => $upcomingMeetings]);
    }

    public function registerMeeting(Request $request) {
        // $email = $request->input('email');
        $idMeeting = $request->idMeeting;
        $idBusiness = $request->idBusiness;
        
        error_log("tes");
        error_log($idMeeting);
        error_log($idBusiness);
        $registerMeeting = RegisteredMeetings::create([
            "user_id" => Auth::user()->id,
            "business_id" => $idBusiness,
            "meeting_id" => $idBusiness,
        ]);
        error_log($registerMeeting);
        return response()->json(['exists' => $registerMeeting]);
    }

    public function addMeeting(Request $request)
    {
        try {
            $data = $request->validate([
                'date' => 'required|date',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'business_id' => 'required'
            ]);

            // Save the meeting to the database
            Meeting::create([
                'date' => $data['date'],
                'title' => $data['title'],
                'description' => $data['description'],
                'business_id' => $data['business_id']
            ]);

            // Return a JSON response indicating success
            return response()->json(['success' => true], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error($e->getMessage());

        // Return an error response
        return response()->json(['success' => false, 'message' => 'Error adding meeting'], 500);
        }
    }

    public function editMeeting(Request $request) {
        $request->validate([
            'idMeeting' => 'required|exists:meetings,id',
            'dateMeeting' => 'required|date',
            'titleMeeting' => 'required|string|max:255',
            'descriptionMeeting' => 'nullable|string',
        ]);

        $idMeeting = $request->idMeeting;
        $idBusiness = $request->idBusiness;
        $dateMeeting = $request->dateMeeting;
        $titleMeeting = $request->titleMeeting;
        $descriptionMeeting = $request->descriptionMeeting;
        
        $updateMeeting = Meeting::where('id', $idMeeting)
                        ->update([
                            'date' => $dateMeeting,
                            'title' => $titleMeeting,
                            'description' => $descriptionMeeting,
                        ]);
        if ($updateMeeting) {
            return response()->json(['success' => '1']);
        } else {
            return response()->json(['success' => '0']);
        }
    }

    public function getMeetingData(Request $request) {
        
        $meetings = Meeting::where('business_id', $request->idBusiness)
                    ->select(['id as idMeeting', 'title', 'description', 'date as start'])
                    ->get();
        error_log($meetings);
        return response()->json(['meetings' => $meetings]);
    }

    public function deleteMeeting(Request $request) {
        error_log("delete meeting data");
        error_log($request->idMeeting);
        error_log($request->idBusiness);
        $deleted = Meeting::where('id', $request->idMeeting)
                      ->where('business_id', $request->idBusiness)
                      ->delete();
        if ($deleted) {
            return response()->json(['success' => '1']);
        } else {
            return response()->json(['success' => '0']);
        }
    }
}
