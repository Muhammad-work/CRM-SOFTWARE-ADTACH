<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
     public function viewAdminTable(){
        $users = user::where('role','admin')->get();
        return view('admin.adminTable',compact('users'));
     }

     public function viewAddForm(){
        return view('admin.add_admin');
     }

     public function storeAdminDetail(Request $req){
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
          'role' => 'admin',
          'created_at' => now(),
          'updated_at' => now(),
        ]);
        
        return redirect()->route('viewAdminTable')->with(['success' => 'Admin Created Successfuly']);
     }

     public function viewEditForm(string $id){
        $user = user::find($id);
        return view('admin.edit_admin',compact('user'));
    }


    public function storeUpdateAdmin(Request $req, string $id){

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

          return redirect()->route('viewAdminTable')->with(['success' => 'Admin Updated Successfuly']);

    }

    public function deleteAdmin(string $id){
        $user = user::find($id);
        $user->delete();
        return redirect()->route('viewAdminTable')->with(['success' => 'Admin Deleted Successfuly']);
    }

}
