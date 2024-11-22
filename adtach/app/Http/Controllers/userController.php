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

        $users = user::get();

       return view('admin.userTable',compact('users'));
    }

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

        $toSendMail = $req->user_email;
        $subject ='Hello ' . $req->user_name . ' Login Now';
        $message ='Email : ' . $req->user_email . ' Password : ' . $req->user_password;
        
        Mail::to( $toSendMail)->send(new sendAgentMail($subject,$message));
        
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

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();

        if ($user->ip_address === null) {
            $user->ip_address = $request->ip();  
            $user->save();  
        } else {
            if ($user->ip_address !== $request->ip()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You cannot log in from this device or location.',
                ]);
            }
        }

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

    }

    public function logout(){
        Session::flush();
        return redirect()->route('login');
    }

    public function sendMail(){
        Mail::to('balochmuhammad817@gmail.com')->send(new sendAgentMail('Hello Muhammad', 'kdmflaksmdflkmslkdmflksm'));
    }

}
