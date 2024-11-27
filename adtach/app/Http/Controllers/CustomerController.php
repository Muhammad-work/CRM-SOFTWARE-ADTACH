<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class CustomerController extends Controller
{
    public function storeCustomerDetail(Request $req){
    //   return now();
        $req->validate([
            'customer_name' => 'required|string',
            'customer_number' => 'required|numeric|unique:customers,customer_number',
            'customer_email' => 'unique:customers,customer_email',
            'price' => 'required|numeric',
            'remarks' => 'required',
            'status' => 'required', 
            'date' => 'required'
        ]);
        
        $email = $req->customer_email ?: 'No Email'; 
        
        $customer = customer::create([
            'customer_name' => $req->customer_name,
            'customer_email' => $email,
            'customer_number' => $req->customer_number,
            'price' => $req->price,
            'remarks' => $req->remarks,
            'status' => $req->status,  
            'a_name' => session('user')->id, 
            'regitr_date' => $req->date
        ]);
        $customer->created_at = now();
        $customer->updated_at = now();
        $customer->regitr_date = $req->date;
        $customer->save();

        $customer->user_name = session('user')->name;
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

                $customers = Customer::where('a_name',session('user')->id)
                                   ->where('status', 'sale')
                                   ->orderByRaw('MONTH(regitr_date) asc')
                                   ->get();
                                   

        $user = User::where('id', session('user')->id)->first();
        // $customers = Customer::where('a_name', session('user')->id)->where('status','sale')->get();
        // $user = user::where('id', session('user')->id)->first();
        return view('front.customer_sale',compact(['user','customers']));
    }

    public function customerLeadTable(){

        $customers = Customer::where('a_name', session('user')->id)->where('status','lead')->get();
        $user = user::where('id', session('user')->id)->first();
        return view('front.customer_lead',compact(['user','customers']));
    }

    

    public function customerTrialTable(){

        $customers = Customer::where('a_name',session('user')->id)->where('status','trial')->get();
        $user = user::where('id',session('user')->id)->first();
        return view('front.customer_trial',compact(['user','customers']));
    }
}
