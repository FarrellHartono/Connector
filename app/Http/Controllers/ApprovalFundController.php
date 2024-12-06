<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Investment;
use Illuminate\Http\Request;

class ApprovalFundController extends Controller
{
    public function approvalView($businessId)
    {
        $business = Business::findOrFail($businessId);

        // Check if the logged-in user owns this business
        if (auth()->id() !== $business->user_id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Fetch pending transactions
        $pendingTransactions = Investment::where('business_id', $businessId)
            ->where('status', 0) // Pending
            ->get();

        return view('approvalFund', compact('business', 'pendingTransactions'));
    }

    public function approveTransaction(Request $request, $investmentId)
    {
        $investment = Investment::findOrFail($investmentId);

        // Check if the logged-in user owns the business
        $business = Business::findOrFail($investment->business_id);
        if (auth()->id() !== $business->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Kalau misalnya ada yang udah di approve cek dlu
        $approvedInvestment = Investment::where('user_id', $investment->user_id)
        ->where('business_id', $investment->business_id)
        ->where('status', 1)
        ->first();

        if ($approvedInvestment) {
            // nambah kalau misalnya yang sebelumnya udah ada biar di kumulatifin
            $approvedInvestment->amount += $investment->amount;
            $approvedInvestment->save();

            // Delete investmentnya biar, user yang sama masih perlu approve
            $investment->delete();
        } else {
            // Approve the new investment kalau misalnya sebelumnya belum ada approval
            $investment->status = 1;
            $investment->save();
        }
        
        $message = 'Transaction Approved Successfully!';

        return redirect()->back()
        ->with(['success'=> $message,]);
    }

    public function declineTransaction($investmentId)
    {
        $investment = Investment::findOrFail($investmentId);

        // Check if the logged-in user owns the business
        $business = Business::findOrFail($investment->business_id);
        if (auth()->id() !== $business->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $investment->delete();

        return redirect()->back()->with('message', 'Transaction declined successfully!');
    }
}
