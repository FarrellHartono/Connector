<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Traits\Sortable;
use App\Models\Investment;
use App\Models\Meeting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
            'endDate' => 'required|after_or_equal:startDate',
            'nominal' => 'required',
            'address'=>'required',
            'phone'=>'required',
        ],[
            'endDate.after_or_equal' => 'The end date must be a date after or equal to the start date.',
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
        $userId = auth()->id();

        $businesses = Business::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => '/public/assets/business/'.$request->title,
            'start_date' => $request -> startDate,
            'end_date' => $request-> endDate,
            'nominal' => $request-> nominal,
            'address' => $request-> address,
            'phone_number' => $request -> phone,
            'user_id' => $userId,

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
        $business = Business::findOrFail($id);
        return view('manageBusiness', compact('business'));
    }

    public function updateBusiness(Request $request, $id){
        $request->validate([
            'description' => 'required|max:255',
            'image' => 'image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'file.*'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'startDate' => 'required',
            'endDate' => 'required',
            'nominal' => 'required',
        ]
        );


        $filePath = 'public/assets/business/'.'/'.$request->title;
        Storage::makeDirectory($filePath);

        if($request->file('image')){
            $files = Storage::disk('public')->files(str_replace('public/', '', $filePath));
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_FILENAME) === 'main') {
                    Storage::disk('public')->delete($file);
                }
            }
            $imageName = 'main'.'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('/public/assets/business/'.$request->title,$imageName);
        }

        if($request->file('file')){
            $files = Storage::disk('public')->files(str_replace('public/', '', $filePath));
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_FILENAME) !== 'main') {
                    Storage::disk('public')->delete($file);
                }
            }
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
        }

        // $fileName = $request->title . '.' . $request->file('file')->getClientOriginalExtension();
        // $filePath = $request->file('file')->storeAs('/public/assets/business', $fileName);
        // $userID = $request->Auth::user()->id();

        $business = Business::findOrFail($id);

        $business->description = $request->description;

        return redirect()->route('listBusiness')->with('success', 'Business updated successfully!');
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

        $imageFolderPath = storage_path('app' . $business->image_path);

        $imageFiles = [];
        if (File::exists($imageFolderPath)) {
            $allFiles = File::files($imageFolderPath); // Returns array of file paths
            
            $mainFile = null;
            $otherFiles = [];
            // Separasi main dari file lain
            foreach ($allFiles as $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                if (strtolower($filename) === 'main') {
                    $mainFile = $file;
                } else {
                    $otherFiles[] = $file;
                }
            }
            // main dlu
            if ($mainFile) {
                $imageFiles[] = $mainFile;
            }
            // baru masukin yg laen
            $imageFiles = array_merge($imageFiles, $otherFiles);
        }


        return view('businessDetail', compact('business', 'investments', 'imageFiles'));
    }

    public function transaction(Request $request, $businessId)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $business = Business::findOrFail($businessId);
        $userId = auth()->id();

        // Buat nyari apakah user sudah pernah invest di bisnis ini.
        $investment = Investment::where('user_id', $userId)
            ->where('business_id', $businessId)
            ->first();

            $action = $request->input('action');

            if ($action === 'invest') {
                // Logic Investment
                if ($investment) {
                    $investment->amount += $validatedData['amount'];
                    $investment->save();
                } else {
                    Investment::create([
                        'user_id' => $userId,
                        'business_id' => $businessId,
                        'amount' => $validatedData['amount'],
                    ]);
                }

                $message = 'Investment successful!';
            } elseif ($action === 'withdraw') {
                // Logic Withdraw
                if (!$investment) {
                    return redirect()->back()->with('error', 'No investment found.');
                }

                $withdrawalAmount = $validatedData['amount'];
                if ($withdrawalAmount > $investment->amount) {
                    return redirect()->back()->with('error', 'Withdrawal amount exceeds your investment.');
                }

                $investment->amount -= $withdrawalAmount;
                $investment->save();

                $message = 'Withdrawal successful!';
            } else {
                return redirect()->back()->with('error', 'Invalid transaction type.');
            }

            return redirect()->route('business.show', $businessId)
                ->with([
                    'success' => $message,
                    'error' => $action === 'withdraw' && $withdrawalAmount > $investment->amount
                        ? 'Withdrawal amount exceeds your investment.'
                        : null,
                ]);
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
    $user = auth()->id();

            $businesses->where(function ($query) use($user): void  {
                $query->where('user_id', 'like', $user);
            });

        $businesses = $this->applySorting($businesses, $request);

    return view('listBusiness',['businesses' => $businesses->get()] );
}

    public function detailProfile(){
        return view("profileDetail");
    }
    public function welcome(Request $request){
        $businesses = Business::whereIn('id', [1, 2, 3])->get();

            // Return the welcome view and pass the businesses to it
            return view('welcome', compact('businesses'));
    }
}

