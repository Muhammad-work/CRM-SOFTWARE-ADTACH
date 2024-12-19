<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\help;
use App\Models\customer;
use Carbon\Carbon;

class dashboardController extends Controller
{
     public function viewDashboard(){
        $userCount = user::where('role','user')->count();
        $sale = customer::whereMonth('created_at',now())->where('status','sale')->count();
        $trial = customer::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)->where('status','trial')->count();
        $lead = customer::whereMonth('created_at',now())->where('status','lead')->count();
        $help = help::where('status','pending')->count();
        $price = Customer::whereMonth('created_at',now())->sum('price');
        $customerExpriDate = customer::whereDate('regitr_date',today())->get();
        return  view('admin.dashbord',compact(['userCount','sale','trial','lead','price','help','customerExpriDate']));
     }

     public function  viewAgentSaleTable(){
      
       $customers = Customer::with('user')
      ->where('status', 'sale')
      ->orderByRaw('MONTH(regitr_date) desc')  // Sorting by the month part of 'registration_date'
      ->get();

       return view('admin.agent_sale',compact('customers'));
     }

     public function cutomerUPdateSaleDetailFormVIew(string $id){
      $customer = customer::find($id); 

     return view('admin.edit_agent_sale',compact('customer'));
}

public function cutomerUPdateDetailSaleStore(Request $req, string $id){
  $req->validate([
    'customer_name' => 'required|string',
    'customer_number' => 'required|numeric',
    'price' => 'required|numeric',
    'remarks' => 'required',
    'status' => 'required', 
]);

    $customer = customer::find($id);
    $email = $req->customer_email ?: 'No Email'; 
    $customer->update([
      'customer_name' => $req->customer_name,
      'customer_email' => $email,
      'customer_number' => $req->customer_number,
      'price' => $req->price,
      'remarks' => $req->remarks,
      'status' => $req->status,  
        'regitr_date' => $req->date,  
    ]);
    $customer->make_address = $req->make_address;
     $customer->regitr_date = $req->date;
    $customer->save();
    return  redirect()->route('viewAgentSaleTable')->with(['success' => 'Customer Detail Update Successfuly']);
 }

 public function deleteSaleCustomerDetails(string $id){
  $customer = customer::find($id);
  $customer->delete();
  return  redirect()->route('viewAgentSaleTable')->with(['success' => 'Customer Detail Deleted Successfuly']);
}

     public function  viewAgentLeadlTable(){

       $customers = Customer::with('user')
      ->where('status', 'lead')
      ->orderByRaw('MONTH(regitr_date) asc')  // Sorting by the month part of 'registration_date'
      ->get();

       return view('admin.agent_lead',compact('customers'));
     }

     public function cutomerUPdateDetailFormVIew(string $id){
       $customer = customer::find($id); 

      return view('admin.edit_agent_lead',compact('customer'));
 }

   public function cutomerUPdateDetailStore(Request $req, string $id){
  
    $req->validate([
      'customer_name' => 'required|string',
      'customer_number' => 'required|numeric',
      'price' => 'required|numeric',
      'remarks' => 'required',
      'status' => 'required', 
      
  ]);
  
      $customer = customer::find($id);
      $email = $req->customer_email ?: 'No Email'; 
      $customer->update([
        'customer_name' => $req->customer_name,
        'customer_email' => $email,
        'customer_number' => $req->customer_number,
        'price' => $req->price,
        'remarks' => $req->remarks,
        'status' => $req->status,  
         'regitr_date' => $req->date, 
      ]);
      $customer->make_address = $req->make_address;
       $customer->regitr_date = $req->date;
      $customer->save();

      return  redirect()->route('viewAgentLeadlTable')->with(['success' => 'Customer Detail Updated Successfuly']);
   }

   public function deleteLeadCustomerDetails(string $id){
      $customer = customer::find($id);
      $customer->delete();
      return  redirect()->route('viewAgentLeadlTable')->with(['success' => 'Customer Detail Deleted Successfuly']);
   }

     public function  viewAgentTrialTable(){
      
       $customers = Customer::with('user')
      ->where('status', 'trial')
      ->orderByRaw('MONTH(regitr_date) asc')  // Sorting by the month part of 'registration_date'
      ->get();
       return view('admin.agent_trial',compact('customers'));
     }

     public function cutomerUPdateTrialDetailFormVIew(string $id){
      $customer = customer::find($id); 

     return view('admin.edit_agent_trial',compact('customer'));
}

public function cutomerUPdateDetailTrialStore(Request $req, string $id){
  $req->validate([
    'customer_name' => 'required|string',
    'customer_number' => 'required|numeric',
    'price' => 'required|numeric',
    'remarks' => 'required',
    'status' => 'required', 
]);

    $customer = customer::find($id);
    $email = $req->customer_email ?: 'No Email'; 
    $customer->update([
      'customer_name' => $req->customer_name,
      'customer_email' => $email,
      'customer_number' => $req->customer_number,
      'price' => $req->price,
      'remarks' => $req->remarks,
      'status' => $req->status,  
        'regitr_date' => $req->date,  
    ]);

    $customer->make_address = $req->make_address;
     $customer->regitr_date = $req->date;
    $customer->save();

    return  redirect()->route('viewAgentTrialTable')->with(['success' => 'Customer Detail Update Successfuly']);
 }

 public function deleteTrialCustomerDetails(string $id){
  $customer = customer::find($id);
  $customer->delete();
  return  redirect()->route('viewAgentTrialTable')->with(['success' => 'Customer Detail Deleted Successfuly']);
}



    public function updateCustomerStatus(string $id){
        $customer = customer::find($id);
        $customer->status = 'sale';
        $customer->active_status = null;
        $customer->make_address = null;
        $customer->start_date = null;
        $customer->end_date = null;
        $customer->date_count = null;
        $customer->save();
        return  redirect()->route('viewAgentTrialTable')->with(['success' => 'Customer Detail Updated Successfuly']);
      }
      
      public function deleteCustomerDetails(string $id){
        $customer = customer::find($id);
        $customer->delete();
        return  redirect()->route('viewAgentTrialTable')->with(['success' => 'Customer Cencel Successfuly']);
    }


    public function viewHelpRequestTableDashboard(){
      $helpRequest = help::all();
       return view('admin.helpTable',compact('helpRequest'));
    }

    public function downHelpRequestStatus(string $id){
      $help = help::find($id);
      $help->status = 'down';
      $help->save();
      return redirect()->route('viewHelpRequestTableDashboard')->with(['success' => 'Help Request is Down Successfuly']);     
    }

    public function cancelHelpRequestStatus(string $id){
      $help = help::find($id);
      $help->status = 'cancel';
      $help->save();
      return redirect()->route('viewHelpRequestTableDashboard')->with(['success' => 'Help Request is Cancel Successfuly']);     
    }

    public function viewTrialDaysForm(string $id){
      $customer = customer::find($id);
      return view('admin.trial_Days',compact('customer'));
    }
    
    public function storeTrialDays(Request $req,string $id){
          $req->validate([
           'make_address' => 'required',
           'start_date' => 'required|date',
           'end_date' => 'required|date|after_or_equal:start_date',
         ]);

         $startDate = new \DateTime($req->start_date);
         $endDate = new \DateTime($req->end_date);

  
         $interval = $startDate->diff($endDate);
         $daysDifference = $interval->days; 
         $customer = Customer::find($id);
         $customer->active_status = 'active';
         $customer->make_address = $req->make_address;
         $customer->start_date = $req->start_date;
         $customer->end_date = $req->end_date;
         $customer->date_count = $daysDifference;
         $customer->save();

         return redirect()->route('viewAgentTrialTable')->with(['success' => 'Customer Trial Days Is Start Now']);

    }

    public function updateStatusCustomerTrial(){
      $customers = Customer::where('active_status', 'active')->get();

      foreach ($customers as $customer) {
          if ($customer->date_count > 0) {
              $customer->date_count = (int) $customer->date_count - 1;

              if ($customer->date_count == 0) {
                  $customer->active_status = 'inactive';
              }

              $customer->save();
          }
      }

      return response()->json(['status' => 'Update complete']);
    }

    public function viewupdateSaleCustomerStatus(string $id){
      $customer = customer::find($id);
      return view('admin.update_sale_days',compact('customer'));
    }
     public function updateSaleCustomerStatus(Request $req,string $id){
      $req->validate([
        'make_address' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
      ]);

      $startDate = new \DateTime($req->start_date);
      $endDate = new \DateTime($req->end_date);

      $interval = $startDate->diff($endDate);
      $daysDifference = $interval->days; 
      $customer = Customer::find($id);
      $customer->active_status = 'active';
      $customer->make_address = $req->make_address;
      $customer->start_date = $req->start_date;
      $customer->end_date = $req->end_date;
      $customer->date_count = $daysDifference;
      $customer->save();
      return redirect()->route('viewAgentSaleTable')->with(['success' => 'Customer Sale Days Is Start Now']);
     }

     public function viewSaleDaysForm(string $id){
      $customer = customer::find($id);
      return view('admin.sale_days',compact('customer'));
    }

    public function addSaleCustomerStatus(Request $req,string $id){
      $req->validate([
        'make_address' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
      ]);

      $startDate = new \DateTime($req->start_date);
      $endDate = new \DateTime($req->end_date);

      $interval = $startDate->diff($endDate);
      $daysDifference = $interval->days; 
      $customer = Customer::find($id);
      $customer->active_status = 'active';
      $customer->make_address = $req->make_address;
      $customer->start_date = $req->start_date;
      $customer->end_date = $req->end_date;
      $customer->date_count = $daysDifference;
      $customer->save();
      return redirect()->route('viewAgentSaleTable')->with(['success' => 'Customer Sale Days Is Start Now']);
     }
}