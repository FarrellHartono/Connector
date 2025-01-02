<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Traits\Sortable;
use App\Models\Investment;
use App\Models\Meeting;
use App\Models\RegisteredMeetings;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class BusinessController extends Controller
{
    public function upload(Request $request)
    {
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

        $userId = auth()->id();

        $businesses = Business::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => '/public/assets/business/'.$request->title,
            'nominal' => $request-> nominal,
            'address' => $request-> address,
            'phone_number' => $request -> phone,
            'user_id' => $userId,
            'status'=> $status = 0,

        ]);

        return redirect()->route('home')->with('success', 'Business created successfully!');
    }

    public function checkTitle(Request $request){
        $title = $request->query('title');

        $exists = Business::where('title','LIKE', $title)->exists();

        error_log($title);
        error_log($exists);

        return response($exists ? 'false' : 'true');
    }

    public function uploadPage()
    {
        return view('create');
    }

    use Sortable;



    public function home(Request $request)
    {
        $businesses = Business::query()->where('status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $businesses->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $businesses = $this->applySorting($businesses, $request);

        $businesses = $businesses->get();

        return view('home', compact('businesses'));
    }

    public function detailProfile(Request $request)
    {
        // $investmentsQuery = Investment::join('users', 'investments.user_id', '=', 'users.id')
        //     ->join('businesses', 'investments.business_id', '=', 'businesses.id')
        //     ->groupBy('investments.user_id', 'investments.business_id'); // Filter by business ID


        // $investments = $this->applySortingInvestors($investmentsQuery, $request)
        //     ->select(DB::raw('SUM(investments.amount) as total_investment'), 'investments.*', 'businesses.*', 'users.*', 'users.name as investor_name')
        //     ->get();

        $investments = Investment::with(['user', 'business'])
                                        ->select('user_id', 'business_id', DB::raw('SUM(amount) as total_amount'))
                                        ->groupBy('user_id', 'business_id')
                                        ->having('user_id', Auth::user()->id)
                                        ->get();
        // dd("investments: ", $investments);
        return view('profileDetail', compact('investments'));
    }

    public function manage($id)
    {
        $business = Business::findOrFail($id);
        return view('manageBusiness', compact('business'));
    }

    public function updateBusiness(Request $request, $id){
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

        $business = Business::findOrFail($id);
        $business->description = $request->description;
        $business->address = $request->address;
        $business->phone_number = $request->phone;
        $business->save();

        return redirect()->route('listBusiness')->with('success', 'Business updated successfully!');
    }

    public function viewBusinessDetail(Request $request, $id)
    {

        $business = Business::findOrFail($id);
        error_log("asd");
        error_log($business);
        $investmentsQuery = Investment::join('users', 'investments.user_id', '=', 'users.id')
            ->join('businesses', 'investments.business_id', '=', 'businesses.id')
            ->where('businesses.id', $id); // Filter by business ID
        

        $investments = $this->applySortingInvestors($investmentsQuery, $request)
            ->select('investments.*', 'users.name as investor_name')
            ->where('investments.status', 1)
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
        $action = $request->input('action');

        // Buat nyari apakah user sudah pernah invest di bisnis ini.
        $investment = Investment::where('user_id', $userId)
            ->where('business_id', $businessId)
            ->first();

            if ($action === 'invest') {
                $investmentAmount = $validatedData['amount'];
                $remainingNominal = $business->nominal - $business->current_investment;

                if($investmentAmount > $remainingNominal){
                    return redirect()->back()->with('error', 'Investment exceeds the target amount.');
                }

                Investment::create([
                    'user_id' => $userId,
                    'business_id' => $businessId,
                    'amount' => $investmentAmount,
                    'status' => 0, // Status untuk accept atau deny.
                    'deposit_date'=> now(),
                ]);

                $message = 'Investment submitted for approval!';

            } elseif ($action === 'withdraw') {
                // Check dlu statusnya biar gk withdraw langsung
                $investment = Investment::where('user_id', $userId)
                ->where('business_id', $businessId)
                ->where('status', 1) // Only approved investments
                ->first();

                if (!$investment) {
                    return redirect()->back()->with('error', 'No approved investment found for withdrawal.');
                }

                $withdrawalAmount = $validatedData['amount'];
                if ($withdrawalAmount > $investment->amount) {
                    return redirect()->back()->with('error', 'Withdrawal amount exceeds your investment.');
                }

                $investment->amount -= $withdrawalAmount;

                $business->current_investment -= $withdrawalAmount;
                $business->save();

                // Kalau misalnya amountnya udah 0 delete
                if ($investment->amount == 0) {
                        $investment->delete();
                    } else {
                        $investment->save();
                    }

                $message = 'Withdrawal successful!';
            } else {
                return redirect()->back()->with('error', 'Invalid transaction type.');
            }

            return redirect()->route('business.show', $businessId)
                ->with([
                    'success' => $message
                ]);
    }

    

public function listBusiness(Request $request){
    $businesses = Business::query();
    $user = auth()->id();


    $businesses->where(function ($query) use ($user) {
        $query->where('user_id', 'like', $user);
    });


    $businesses = $this->applySorting($businesses, $request);


    $acc = Business::where('user_id', $user)->where('status', '1')->count();
    $pend = Business::where('user_id', $user)->where('status', '0')->count();
    $rej = Business::where('user_id', $user)->where('status', '2')->count();
    $tot = Business::where('user_id', $user)->count();

    return view('listBusiness', ['businesses' => $businesses->get(), 'acc' => $acc,'pend' => $pend, 'rej' => $rej,'tot'=>$tot]);
}

    public function welcome(Request $request){
        $businesses = Business::whereIn('id', [1, 2, 3])->get();

            // Return the welcome view and pass the businesses to it
            return view('welcome', compact('businesses'));
    }

    
}

