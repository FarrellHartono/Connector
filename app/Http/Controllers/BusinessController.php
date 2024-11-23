<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Traits\Sortable;
use App\Models\Investment;
use App\Models\Meeting;
use Illuminate\Support\Facades\Storage;

class BusinessController extends Controller
{
    public function upload(Request $request)
    {


        $request->validate([
            'title' => 'required|max:50|unique:businesses',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'file' => 'required',
            'file.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'startDate' => 'required',
            'endDate' => 'required',
        ]
        );

        $filePath = 'public/assets/business/'.'/'.$request->title;
        Storage::makeDirectory($filePath);

        $imageName = 'main'.'.'. $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('/public/assets/business/'.$request->title,$imageName);


        $count = 1;
        if($files = $request->file('file')){
            foreach($files as $file){
                $image_name = (string)$count;
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $file->storeAs('/public/assets/business/'.$request->title,$image_full_name);
                $count++;

            }
        }

        // $fileName = $request->title . '.' . $request->file('file')->getClientOriginalExtension();
        // $filePath = $request->file('file')->storeAs('/public/assets/business', $fileName);
        // $userID = $request->Auth::user()->id();


        $businesses = Business::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => '/public/assets/business/'.$request->title,
            'start_date' => $request -> startDate,
            'end_date' => $request-> endDate,
            'user_id' => 2
        ]);

        return redirect()->route('home')->with('success', 'Business created successfully!');
    }

    public function uploadPage()
    {
        return view('create');
    }

    use Sortable;



    public function home(Request $request)
    {

        $businesses = Business::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $businesses->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $businesses = $this->applySorting($businesses, $request);
        return view('home', ['businesses' => $businesses->get()]);


    }

    public function manage($id)
    {
        $business = Business::findOrFail($id); // Find the business by id
        return view('manageBusiness', compact('business'));
    }

    public function viewBusinessDetail(Request $request, $id)
    {

        $business = Business::findOrFail($id);

        $investmentsQuery = Investment::join('users', 'investments.user_id', '=', 'users.id')
            ->join('businesses', 'investments.business_id', '=', 'businesses.id')
            ->where('businesses.id', $id); // Filter by business ID


        $investments = $this->applySortingInvestors($investmentsQuery, $request)
            ->select('investments.*', 'users.name as investor_name')
            ->get();
        // Buat Nge test
            // dd($investmentsQuery->toSql(), $investmentsQuery->getBindings());

        return view('businessDetail', compact('business', 'investments'));
    }

    public function buy(Request $request, $businessId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $business = Business::findOrFail($businessId);
        $userId = auth()->id();

        // Buat nyari apakah user sudah pernah invest di bisnis ini.
        $investment = Investment::where('user_id', $userId)
            ->where('business_id', $businessId)
            ->first();
        if ($investment) {
            $investment->amount += $request->input('amount');
            $investment->save();
        } else {
            Investment::create([
                'user_id' => auth()->id(),
                'business_id' => $businessId,
                'amount' => $request->input('amount'),
            ]);

        }
        return redirect()->route('business.show', $businessId)
            ->with('success', 'Investment successful!');
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

public function listBusiness(Request $request){
    $businesses = Business::query();
    $user = 1;

            $businesses->where(function ($query) use($user): void  {
                $query->where('user_id', 'like', $user);
            });

        $businesses = $this->applySorting($businesses, $request);

    return view('listBusiness',['businesses' => $businesses->get()] );
}

    public function detailProfile(){
        return view("profileDetail");
    }
}
