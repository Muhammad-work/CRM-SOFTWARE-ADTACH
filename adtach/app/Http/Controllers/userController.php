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

        $address = '';

        if($req->user_address){
            $address = $req->user_address;
        }else{
            $address = 'No Address';
        }
         
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
       // Validate the incoming request   
       $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);
    
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Get the authenticated user
        $user = Auth::user();
    
        // Check if the user's role is 'admin'
        if ($user->role === 'admin') {
            return redirect()->route('dashboard'); // Redirect to admin dashboard
        } else {
            return redirect()->route('viewHome'); // Redirect to regular user home
        }
    } else {
        // Return error message if login fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    }

    public function logout(){
        Session::flush();
        return redirect()->route('login');
    }

}
