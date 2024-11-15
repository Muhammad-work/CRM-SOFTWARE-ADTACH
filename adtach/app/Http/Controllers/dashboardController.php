<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\customer;

class dashboardController extends Controller
{
     public function viewDashboard(){
        $userCount = user::where('role','user')->count();
        $sale = customer::where('status','sale')->count();
        $trial = customer::where('status','trial')->count();
        $lead = customer::where('status','lead')->count();
        $price = Customer::sum('price');
        return  view('admin.dashbord',compact(['userCount','sale','trial','lead','price']));
     }

     public function  viewAgentSaleTable(){
      
       $customers = Customer::with('user')->where('status','sale')->get();

       return view('admin.agent_sale',compact('customers'));
     }

     public function  viewAgentLeadlTable(){
      
       $customers = Customer::with('user')->where('status','lead')->get();

       return view('admin.agent_lead',compact('customers'));
     }

     public function  viewAgentTrialTable(){
      
       $customers = Customer::with('user')->where('status','trial')->get();

       return view('admin.agent_trial',compact('customers'));
     }
}
