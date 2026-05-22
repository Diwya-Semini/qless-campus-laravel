<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Canteen;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // load the dash with pending and active canteens
    public function dashboard(){
        // get canteen waiting for approval
        $pendingCanteens = Canteen::where('status', 'pending');

        // get canteens that are already live
        $activeCanteens = Canteen::whereIn('status', ['active', 'approved'])->get();

        return view('uni_admin.canteens', compact('pendingCanteens', 'activeCanteens'));
    }

    // action to approve a pending canteen
    public function approveCanteen(){
        $canteen = Canteen::findOrfail($id);
        $canteen->update(['status' => 'approved']);

        return redirect()-> back()->with('success', $canteen->name . 'has been approved and is now live on the network');

    }
}
