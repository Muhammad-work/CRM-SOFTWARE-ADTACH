<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\user;

use Illuminate\Support\Facades\Auth;

class homeController extends Controller
{
    public function viewHome(){
       
       $customers = Customer::where('a_name', Auth::id())->get();
       $user = user::where('id',Auth::id())->first();
        return view('front.home',compact(['customers','user']));
    }
}
