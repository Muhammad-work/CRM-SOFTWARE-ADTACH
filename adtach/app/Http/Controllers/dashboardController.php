<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\help;
use App\Models\customer;
use App\Models\client_number;
use App\Models\customerNumber;
use App\Models\old_number;
use App\Models\oldCustomer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function viewDashboard(Request $req)
    {
        $date = $req->date ?? now();
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $userCount = user::where('role', 'user')->count();
        $oldsale = customer::whereMonth('regitr_date', $month)
            ->whereYear('regitr_date', $year)
            ->where('status', 'sale')
            ->count();
        $Newsale = oldCustomer::whereMonth('regitr_date', $month)
            ->whereYear('regitr_date', $year)
            ->where('status', 'sale')
            ->count();
        $sale = $oldsale + $Newsale;
        $trial = customer::whereMonth('regitr_date', $month)
            ->whereYear('regitr_date', $year)
            ->where('status', 'trial')
            ->count();
        $lead = customer::whereMonth('regitr_date', $month)
            ->whereYear('regitr_date', $year)
            ->where('status', 'lead')
            ->count();
        $help = help::where('status', 'pending')->count();
        $oldCutomerprice = Customer::where('status', 'sale')->whereMonth('regitr_date', $month)
            ->whereYear('regitr_date', $year)
            ->sum('price');
        $NewCustomerprice = oldCustomer::where('status', 'sale')->whereMonth('regitr_date', $month)
            ->whereYear('regitr_date', $year)
            ->sum('price');
        $price = $oldCutomerprice + $NewCustomerprice;
        $oldSalecustomerExpriDate = Customer::with('user')
            ->whereDate('regitr_date', today())
            ->get();
        $NewSalecurentSale = OldCustomer::with('user')
            ->whereDate('regitr_date', today())
            ->get();
        $curentSale = $oldSalecustomerExpriDate->merge($NewSalecurentSale);

        return view('admin.dashbord', compact([
            'userCount',
            'sale',
            'trial',
            'lead',
            'price',
            'help',
            'curentSale'
        ]));
    }

    public function  viewAgentSaleTable()
    {
        $customers = Customer::with('user')
            ->select('a_name', DB::raw('count(*) as total'))
            ->groupBy('a_name')
            ->where('status', 'sale')
            ->orderBy('regitr_date', 'desc')
            ->get();

        return view('admin.agent_sale', compact('customers'));
    }

    public function viewSaleTable(Request $req, string $id)
    {
        $month = date('m', strtotime($req->date));
        $year = date('Y', strtotime($req->date));
        if ($req->date == null) {
            $oldcustomers = Customer::with('user')
                ->where('status', 'sale')
                ->orderBy('regitr_date', 'desc')
                ->where('a_name', $id)
                ->get();
            $Newcustomers = oldCustomer::with('user')
                ->where('status', 'sale')
                ->orderBy('regitr_date', 'desc')
                ->where('agent', $id)
                ->get();
        } else {
            $oldcustomers = Customer::with('user')
                ->where('status', 'sale')
                ->whereMonth('regitr_date', $month)
                ->whereYear('regitr_date', $year)
                ->where('a_name', $id)
                ->get();
            $Newcustomers = oldCustomer::with('user')
                ->where('status', 'sale')
                ->whereMonth('regitr_date', $month)
                ->whereYear('regitr_date', $year)
                ->where('agent', $id)
                ->get();
        }
        $customers = $oldcustomers->merge($Newcustomers);
        return view('admin.sale_table', compact('customers'));
    }

    public function cutomerUPdateSaleDetailFormVIew(string $id)
    {
        $oldcustomers = customer::find($id);
        $Newcustomers = oldcustomer::find($id);
        $customer = null;
        if ($oldcustomers) {
            $customer = $oldcustomers;
        } else {
            $customer = $Newcustomers;
        }
        return view('admin.edit_agent_sale', compact('customer'));
    }

    public function cutomerUPdateDetailSaleStore(Request $req, string $id)
    {
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
            'expiry_date' => $req->expiry_date
        ]);
        $customer->make_address = $req->make_address;
        $customer->regitr_date = $req->date;
        $customer->save();
        return  redirect()->route('viewAgentSaleTable')->with(['success' => 'Customer Detail Update Successfuly']);
    }

    public function deleteSaleCustomerDetails(string $id)
    {
        $oldcustomer = customer::find($id);
        $newcustomer = oldcustomer::find($id);
        $customer = null;
        if ($oldcustomer) {
            $customer = $oldcustomer;
        } else {
            $customer = $newcustomer;
        }
        $customer->delete();
        return  redirect()->route('viewAgentSaleTable')->with(['success' => 'Customer Detail Deleted Successfuly']);
    }

    public function  viewAgentLeadlTable()
    {
        $customers = Customer::with('user')
            ->select('a_name', DB::raw('count(*) as total'))
            ->groupBy('a_name')
            ->where('status', 'lead')
            ->orderBy('regitr_date', 'desc')
            ->get();
        return view('admin.agent_lead', compact('customers'));
    }

    public function viewleadtable(string $id)
    {
        $customers = Customer::with('user')
            ->where('status', 'lead')
            ->orderByRaw('MONTH(regitr_date) asc')
            ->where('a_name', $id)
            ->get();
        return view('admin.lead_table', compact('customers'));
    }

    public function distributeLeadsForm(string $id)
    {
        $agentName = Customer::select('a_name')->with('user')->where('status', 'lead')->groupBy('a_name')->where('a_name', '!=', $id)->get();
        $agentID = user::find($id);
        $customer = Customer::where('status', 'lead')->where('a_name', $id)->get();
        return view('admin.dis_lead', compact(['agentName', 'agentID']));
    }

    public function updateLeadAgent(Request $req, string $id)
    {
        $OldLeadAgent = customer::where('status', 'lead')->where('a_name', $id)->take($req->number)->get();
        $disLeadAgent = customer::where('status', 'lead')->where('a_name', $req->agent)->take($req->number)->get();
        foreach ($OldLeadAgent as $oldAgent) {
            foreach ($disLeadAgent as $newAgent) {
                $newAgentID = $newAgent->a_name;
                $newAgentName = $newAgent->user_name;

                $oldAgent->a_name = $newAgentID;
                $oldAgent->user_name = $newAgentName;

                $oldAgent->save();
                $newAgent->save();
            }
        }
        return redirect()->route('viewAgentLeadlTable')->with(['success' => 'Distribute Lead Successfuly']);
    }

    public function cutomerUPdateDetailFormVIew(string $id)
    {
        $customer = customer::find($id);
        return view('admin.edit_agent_lead', compact('customer'));
    }

    public function cutomerUPdateDetailStore(Request $req, string $id)
    {
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

    public function deleteLeadCustomerDetails(string $id)
    {
        $customer = customer::find($id);
        $customer->delete();
        return  redirect()->route('viewAgentLeadlTable')->with(['success' => 'Customer Detail Deleted Successfuly']);
    }

    public function  viewAgentTrialTable()
    {
        $customers = Customer::with('user')
            ->select('a_name', DB::raw('count(*) as total'))
            ->groupBy('a_name')
            ->where('status', 'trial')
            ->orderBy('regitr_date', 'desc')
            ->get();
        return view('admin.agent_trial', compact('customers'));
    }

    public function viewtrialtable(string $id)
    {
        $customers = Customer::with('user')
            ->where('status', 'trial')
            ->orderByRaw('MONTH(regitr_date) asc')
            ->where('a_name', $id)
            ->get();
        return view('admin.trial_table', compact('customers'));
    }

    public function distributeTrialsForm(string $id)
    {
        $agentName = Customer::select('a_name')->with('user')->where('status', 'trial')->groupBy('a_name')->where('a_name', '!=', $id)->get();
        $agentID = user::find($id);
        $customer = Customer::where('status', 'trial')->where('a_name', $id)->get();
        return view('admin.dis_trial', compact(['agentName', 'agentID']));
    }

    public function updateTrialAgent(Request $req, string $id)
    {
        $OldLeadAgent = customer::where('status', 'trial')->where('a_name', $id)->take($req->number)->get();
        $disLeadAgent = customer::where('status', 'trial')->where('a_name', $req->agent)->take($req->number)->get();
        foreach ($OldLeadAgent as $oldAgent) {
            foreach ($disLeadAgent as $newAgent) {
                $newAgentID = $newAgent->a_name;
                $newAgentName = $newAgent->user_name;

                $oldAgent->a_name = $newAgentID;
                $oldAgent->user_name = $newAgentName;

                $oldAgent->save();
                $newAgent->save();
            }
        }
        return redirect()->route('viewAgentTrialTable')->with(['success' => 'Distribute Trial Successfuly']);
    }

    public function cutomerUPdateTrialDetailFormVIew(string $id)
    {
        $customer = customer::find($id);

        return view('admin.edit_agent_trial', compact('customer'));
    }

    public function cutomerUPdateDetailTrialStore(Request $req, string $id)
    {
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

    public function deleteTrialCustomerDetails(string $id)
    {
        $customer = customer::find($id);
        $customer->delete();
        return  redirect()->route('viewAgentTrialTable')->with(['success' => 'Customer Detail Deleted Successfuly']);
    }

    public function updateCustomerStatus(string $id)
    {
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

    public function deleteCustomerDetails(string $id)
    {
        $customer = customer::find($id);
        $customer->delete();
        return  redirect()->route('viewAgentTrialTable')->with(['success' => 'Customer Cencel Successfuly']);
    }
    public function viewHelpRequestTableDashboard()
    {
        $helpRequest = help::all();
        return view('admin.helpTable', compact('helpRequest'));
    }
    public function downHelpRequestStatus(string $id)
    {
        $help = help::find($id);
        $help->status = 'down';
        $help->save();
        return redirect()->route('viewHelpRequestTableDashboard')->with(['success' => 'Help Request is Down Successfuly']);
    }

    public function cancelHelpRequestStatus(string $id)
    {
        $help = help::find($id);
        $help->status = 'cancel';
        $help->save();
        return redirect()->route('viewHelpRequestTableDashboard')->with(['success' => 'Help Request is Cancel Successfuly']);
    }

    public function viewTrialDaysForm(string $id)
    {
        $customer = customer::find($id);
        return view('admin.trial_Days', compact('customer'));
    }


    public function updateStatusCustomerTrial()
    {
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

    public function viewupdateSaleCustomerStatus(string $id)
    {
        $customer = customer::find($id);
        return view('admin.update_sale_days', compact('customer'));
    }
    public function updateSaleCustomerStatus(Request $req, string $id)
    {
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

    public function viewSaleDaysForm(string $id)
    {
        $customer = customer::find($id);
        return view('admin.sale_days', compact('customer'));
    }

    public function addSaleCustomerStatus(Request $req, string $id)
    {
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


    public function viewCustomerNumber()
    {
        $allCustomerNumber = CustomerNumber::with('user')->select('agent', DB::raw('count(*) as total'))
            ->groupBy('agent')
            ->get();
        return view('admin.customer_number', compact('allCustomerNumber'));
    }


    public function viewCustomerNumberForm()
    {
        $agentName = User::select('name', 'id')->where('role', 'user')->get();
        $allClientNumbersCount = client_number::count();
        return view('admin.add_customer_number', compact(['agentName', 'allClientNumbersCount']));
    }


    public function viewNumbersTable()
    {
        $numbers = client_number::get();
        return view('admin.number', compact('numbers'));
    }

    public function viewAddNumbersForm()
    {
        return view('admin.add_number');
    }

    public function storeNumbers(Request $req)
    {
        $customerNumberArray = explode("\r\n", $req->customerNumber);
        $customerNumberArray = array_map('trim', $customerNumberArray);
        $customerNumberArray = array_unique($customerNumberArray);

        $existingNumbers = old_number::whereIn('number', $customerNumberArray)->pluck('number')->toArray();
        $existingNumbers = array_merge(
            $existingNumbers,
            client_number::whereIn('number', $customerNumberArray)->pluck('number')->toArray(),
            customerNumber::whereIn('customer_number', $customerNumberArray)->pluck('customer_number')->toArray()
        );

        $newNumbers = array_diff($customerNumberArray, $existingNumbers);

        if (empty($newNumbers)) {
            return redirect()->route('viewNumbersTable')->with(['error' => 'All numbers already exist in the records.']);
        }


        foreach ($newNumbers as $number) {
            client_number::create([
                'number' => $number,
                'date' => Carbon::now()
            ]);
        }

        return redirect()->route('viewNumbersTable')->with(['success' => 'New numbers added successfully']);
    }


    public function storeCustomerNumbers(Request $req)
    {
        $req->validate([
            'agent' => 'required',
            'date' => 'required|date',
            'number' => 'required|integer|min:1',
        ]);

        $number = $req->input('number');
        $clientNumbers = client_number::select('number', 'id')->take($number)->get();
        $customerName = 'No Customer Name';

        foreach ($clientNumbers as $clientNumber) {
            customerNumber::create([
                'customer_name' => $customerName,
                'customer_number' => $clientNumber->number,
                'agent' => $req->agent,
                'date' => $req->date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $clientNumbers->each(function ($clientNumber) {
            $clientNumber->delete();
        });

        return redirect()->route('viewNumbersTable')->with(['success' => 'Distribute To Customer Numbers Successfully']);
    }


    public function viewAgentDistributeNumbersDetail(string $id)
    {
        $customerResponseReports = customerNumber::with('user')->where('agent', $id)->get();
        return view('admin.customer_response', compact('customerResponseReports'));
    }


    public function distributeNumberForm(string $id)
    {
        $allAgent = customerNumber::with('user')->select('agent')->where('agent', '!=', $id)->groupby('agent')->get();
        $agentID = user::find($id);
        return view('admin.dis_to_agent_number', compact('allAgent', 'agentID'));
    }

    public function distributeNumberToAgent(Request $req, string $id)
    {
        $req->validate([
            'new_agent' => 'required',
            'date' => 'required',
            'number' => 'required',
        ]);

        $old_agent = customerNumber::where('agent', $id)->take($req->number)->get();
        foreach ($old_agent as $old) {
            $old->agent = $req->new_agent;
            $old->customer_name = 'No Customer Name';
            $old->date = $req->date;
            $old->status = 'pending';
            $old->remarks = null;
            $old->save();
        }

        return redirect()->route('viewCustomerNumber')->with(['success' => 'Distribute Numbers Successfully']);
    }

    public function viewAgentDistributeSale(string $id)
    {
        $agentName = Customer::select('a_name')->with('user')->where('status', 'sale')->groupBy('a_name')->where('a_name', '!=', $id)->get();
        $agentID = user::find($id);
        return view('admin.dis_sale', compact(['agentName', 'agentID']));
    }

    public function updateSaleAgent(Request $req, string $id)
    {
        $CustomerSaleAgent = customer::where('status', 'sale')->where('a_name', $id)->get();
        $disSaleAgent = customer::where('status', 'sale')->where('a_name', $req->agent)->get();

        $oldCustomerSaleAgent = oldcustomer::where('status', 'sale')->where('agent', $id)->get();

        foreach ($CustomerSaleAgent as $oldAgent) {
            foreach ($disSaleAgent as $newAgent) {
                $oldAgent->a_name = $newAgent->a_name;
                $oldAgent->user_name = $newAgent->user_name;

                $oldAgent->save();
            }
        }

        foreach ($oldCustomerSaleAgent as $oldAgent) {
            foreach ($disSaleAgent as $newAgent) {
                $oldAgent->agent = $newAgent->a_name;

                $oldAgent->save();
            }
        }

        return redirect()->route('viewAgentSaleTable')->with(['success' => 'Distribute Sale Successfully']);
    }

    public function  filterSaleByDate(Request $req)
    {
        $date = Carbon::parse($req->date);
        $month = $date->format('m');

        $oldCustomers = Customer::whereRaw('MONTH(regitr_date) = ?', [$month])->get();
        $newCustomers = OldCustomer::whereRaw('MONTH(regitr_date) = ?', [$month])->get();

        $customers = $oldCustomers->merge($newCustomers);

        return view('admin.all_sale', compact('customers'));
    }

    public function viewPendingSale()
    {
        $oldCustomer = Customer::where('status', 'pending')->get();
        $newCustomer = oldCustomer::where('status', 'pending')->get();
        $customers = $oldCustomer->merge($newCustomer);
        return view('admin.pending_sale', compact('customers'));
    }

    public function acceptPendingSale(string $id)
    {
        $oldCustomer = customer::find($id);
        $newcustomer = oldCustomer::find($id);
        if ($oldCustomer) {
            $oldCustomer->status = 'sale';
            $oldCustomer->save();
            return back()->with(['success' => 'Pending Sale Accepted Successfuly']);
        }
        if ($newcustomer) {
            $newcustomer->status = 'sale';
            $newcustomer->save();
            return back()->with(['success' => 'Pending Sale Accepted Successfuly']);
        }
    }

    public function viewMacExpiryData()
    {
        $oldCustomer = customer::where('status', 'sale')
            ->whereDate('expiry_date', '<=', now())
            ->get();

        $newCustomer = oldCustomer::where('status', 'sale')
            ->whereDate('expiry_date', '<=', now())
            ->get();

        $customers = $oldCustomer->merge($newCustomer);
        $customers = $customers->map(function ($customer) {
            $expiryDate = Carbon::parse($customer->expiry_date);
            $now = Carbon::now();

            $customer->expired_days = intval($expiryDate->diffInDays($now));
            $customer->expired_months = intval($expiryDate->diffInMonths($now));

            return $customer;
        });

        return view('admin.mac_expiry', compact('customers'));
    }

    public function viewAddNewAgentSaleForm()
    {
        $allAgent = user::select('id', 'name')->where('role', 'user')->get();
        return view('admin.add_sale', compact('allAgent'));
    }

    public function saveNewAgentSale(Request $req)
    {
        $req->validate([
            'customer_name' => 'required|string',
            'customer_number' => 'required|numeric|unique:customers,customer_number',
            'status' => 'required',
            'price' => 'required|numeric',
            'remarks' => 'required',
            'date' => 'required|date',
            'agent' => 'required'
        ]);
        $agent = user::select('id', 'name')->find($req->agent);
        $email = $req->customer_email ?: 'No Email';
        $macAddress = $req->make_address ?: null;
        $mac_expiry = $req->expiry_date ?: null;
        customer::create([
            'customer_name' => $req->customer_name,
            'customer_number' => $req->customer_number,
            'customer_email' =>  $email,
            'status' => $req->status,
            'price' => $req->price,
            'remarks' => $req->remarks,
            'regitr_date' => $req->date,
            'a_name' => $agent->id,
            'user_name' => $agent->name,
            'make_address' => $macAddress,
            'expiry_date' =>  $mac_expiry
        ]);

        return redirect()->route('viewAgentSaleTable')->with(['success' => 'New Customer Add Successfuly']);
    }

    public function viewOldNumber()
    {
        $old_number = old_number::get();
        return view('admin.old_number', compact('old_number'));
    }

    public function disOldCustomerNumberToAgent()
    {
        $agentName = User::select('name', 'id')->where('role', 'user')->get();
        $allClientNumbersCount = old_number::count();
        return view('admin.dis_old_number', compact(['agentName', 'allClientNumbersCount']));
    }

    public function storeOldCustomerNumber(Request $req)
    {
        $req->validate([
            'agent' => 'required',
            'date' => 'required|date',
            'number' => 'required|integer|min:1',
        ]);

        $number = $req->input('number');
        $clientNumbers = old_number::select('number', 'id')->take($number)->get();
        $customerName = 'No Customer Name';

        foreach ($clientNumbers as $clientNumber) {
            customerNumber::create([
                'customer_name' => $customerName,
                'customer_number' => $clientNumber->number,
                'agent' => $req->agent,
                'date' => $req->date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $clientNumbers->each(function ($clientNumber) {
            $clientNumber->delete();
        });

        return redirect()->route('viewOldNumber')->with(['success' => 'Distribute To Customer Old Numbers Successfully']);
    }
}
