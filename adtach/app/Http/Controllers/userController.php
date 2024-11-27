<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\sendAgentMail;
use Illuminate\Support\Facades\Mail;

class userController extends Controller
{

    public function viewHome(){
       

        return view('front.home');
    }

    public function viewUserTable(){

        $currentMonth = now()->month; // Current month
        $currentYear = now()->year;  // Current year
    
        // Get all agents
        $agents = User::all();
    
        // Prepare data for sales counts
        $salesData = [];
    
        foreach ($agents as $agent) {
            $salesCount = $agent->getSalesCountForMonth($currentMonth, $currentYear);
            $salesData[$agent->id] = $salesCount; // Store sales count with agent id
        }
    
        $users = User::all(); // Or filter users as needed
        
        // Pass both users and salesData to the view
        // return view('admin.users.index', compact('users', 'salesData'));
    

       return view('admin.userTable', compact('users', 'salesData','currentMonth'));
    }

    // public function lastmontsale(){
    //     $lastMonth = now()->subMonth()->month;
    //     $currentYear = now()->year;

    //     // Get all agents
    //     $agents = Agent::all();

    //     // Prepare data for dashboard
    //     $salesData = [];

    //     foreach ($agents as $agent) {
    //         $salesCount = $agent->getSalesCountForMonth($lastMonth, $currentYear);
    //         $salesData[] = [
    //             'agent_name' => $agent->name,
    //             'sales_count' => $salesCount,
    //         ];
    //     }
    //     return $salesData;
    // }

    public function addUser(){
        return view('admin.add_user');
    }

    public function storeUserdetail(Request $req){
        $req->validate([
            'user_name' => 'required|string',
            'user_email' => 'required|email|unique:users,email',
            'user_phone' => 'required|numeric|unique:users,phone',
            'user_password' => 'required|min:8|max:12|confirmed',
        ]);


        $address = $req->user_address ?: 'No Address';

        // $toSendMail = $req->user_email;
        // $subject ='Hello ' . $req->user_name . ' Login Now';
        // $message ='Email : ' . $req->user_email . ' Password : ' . $req->user_password;
        
        // Mail::to( $toSendMail)->send(new sendAgentMail($subject,$message));
        
        user::insert([
          'name' => $req->user_name,
          'email' => $req->user_email,
          'phone' => $req->user_phone,
          'address' => $address,
          'password' => Hash::make($req->user_password),
          'created_at' => now(),
          'updated_at' => now(),
        ]);
  


        return redirect()->route('viewUserTable')->with(['success' => 'User Created Successfuly']);
    }

    public function viewEditForm(string $id){
        $user = user::find($id);
        return view('admin.edit_user',compact('user'));
    }

    public function storeUpdateUser(Request $req, string $id){

        $req->validate([
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'user_phone' => 'required|numeric',
        ]);

        $address = '';

        if($req->user_address){
            $address = $req->user_address;
        }else{
            $address = 'No Address';
        }

        $user = user::find($id);
        $user->update([
            'name' => $req->user_name,
            'email' => $req->user_email,
            'phone' => $req->user_phone,
            'address' => $address,
            'created_at' => now(),
            'updated_at' => now(),
          ]);
          $user->ip_address = $req->ip;
          $user->save();
         
          return redirect()->route('viewUserTable')->with(['success' => 'User Updated Successfuly']);

    }


    public function deleteUser(string $id){
        $user = user::find($id);
        $user->delete();
        return redirect()->route('viewUserTable')->with(['success' => 'User Deleted Successfuly']);
    }


    public function login(){
         Auth::logout();
        return view('front.login');
    }

    public function loginstore(Request $request){

    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    $user = User::where('email', $request->email)->first();

    // Check if user exists
    if ($user) {
        // Check if the user is active
        if ($user->ip_address === '0') {
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact support.',
            ]);
        }
    
        // Check if the password matches
        if (Hash::check($request->password, $user->password)) {
    
            // Manually store user in session
            session(['user' => $user]);  // Store the entire user object in session
    
            // Check the user's IP address
            if ($user->ip_address === '1') {
                // Set IP address to the current one if it's the first time or it's not set
                $user->ip_address = '1';
                $user->save();
            } else {
                // Compare stored IP address with current IP address
                if ($user->ip_address !== '1') {
                    session()->flush(); // Clear session
                    return back()->withErrors([
                        'email' => 'You cannot log in from this device or location.',
                    ]);
                }
            }
    
            // Redirect based on the user's role
            if ($user->role === 'admin' || $user->role === 'sub_admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('viewHome');
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    } else {
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    }

    public function logout(){
        Session::flush();
        return redirect()->route('login');
    }


    public function activateUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->ip_address = '1';  // Set the user's IP address to the current IP
            $user->save();
            return redirect()->back()->with('success', 'User activated successfully');
        }
    
        return redirect()->back()->with('error', 'User not found');
    }

    public function deactivateUser($id)
{
    $user = User::find($id);
    if ($user) {
        $user->ip_address = '0';  // Set the user's IP address to '0' to mark as inactive
        $user->save();
        return redirect()->back()->with('success', 'User deactivated successfully');
    }

    return redirect()->back()->with('error', 'User not found');
}
    
}
