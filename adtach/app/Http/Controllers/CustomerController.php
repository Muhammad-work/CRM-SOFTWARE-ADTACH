<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\user;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function storeCustomerDetail(Request $req){
    //   return now();
        $req->validate([
            'customer_name' => 'required|string',
            'customer_number' => 'required|numeric|unique:customers,customer_number',
            'customer_email' => 'unique:customers,customer_email',
            // 'price' => 'numeric',
            'remarks' => 'required',
            'status' => 'required', 
        ]);
        
        $email = $req->customer_email ?: 'No Email'; 
        $price = $req->price ?: '00.00'; 
        
        $customer = customer::create([
            'customer_name' => $req->customer_name,
            'customer_email' => $email,
            'customer_number' => $req->customer_number,
            'price' => $price,
            'remarks' => $req->remarks,
            'status' => $req->status,  
            'a_name' => Auth::id(), 
        ]);
        $customer->created_at = now();
        $customer->updated_at = now();
        $customer->save();

        $customer->user_name = Auth::user()->name;
        $customer->save();
        
        return back()->with(['success' => 'Customer Created Successfully']);
    }

    public function customerStatus(Request $req,string $id){
       
        $customer = customer::find($id);
        $customer->update([
            'status' => $req->status
        ]);

        return back()->with(['update' => 'Update Customer Status Successfuly']);
    }

    public function customerSalesTable(){

        $customers = Customer::where('a_name', Auth::id())->where('status','sale')->get();
        $user = user::where('id', Auth::id())->first();
        return view('front.customer_sale',compact(['user','customers']));
    }

    public function customerLeadTable(){

        $customers = Customer::where('a_name', Auth::id())->where('status','lead')->get();
        $user = user::where('id', Auth::id())->first();
        return view('front.customer_lead',compact(['user','customers']));
    }

    

    public function customerTrialTable(){

        $customers = Customer::where('a_name', Auth::id())->where('status','trial')->get();
        $user = user::where('id', Auth::id())->first();
        return view('front.customer_trial',compact(['user','customers']));
    }
}
