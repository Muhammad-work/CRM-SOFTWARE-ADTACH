<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\client_number;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\customerNumber;
use App\Models\user;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function viewHome()
    {

        $customers = Customer::where('a_name', Auth::id())->where('status', 'lead')->orWhere('status', 'trial')->get();
        $user = user::where('id', Auth::id())->first();
        $expiredNumbers = customerNumber::where('date', '<', Carbon::now())->get();
        $numbers = $expiredNumbers->pluck('customer_number')->toArray();

        if ($numbers) {
            foreach ($numbers as $num) {
                client_number::create(['number' => $num]);
            }
            CustomerNumber::where('date', '<', Carbon::now())->delete();
        }
        return view('front.home', compact(['customers', 'user']));
    }
}
