<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Admin;
use DB;
use Date;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->input();
            $adminCount = Admin::where('username', $data['username'])->where('password',\md5 ($data['password']), ['status'=>1])->count();
            if($adminCount > 0) {
             
                Session::put('adminSession', $data['username']);
                return redirect('/admin/dashboard');

            }else{
                
                return redirect('/admin')->with('flash_message_error','invalid_username_or_password');
            }
        }

        return view('admin.admin_login'); 
    }

    public function dashboard() {

        // if(Session::has('adminSession')) {

        // }else{
        //     return redirect('/admin')->with('flash_message_error','Please login to access');
        // }
        return view('admin.dashboard');
    }


    public function profileRole()
    {
        $adminRole = Admin::where('username', Session::get('adminSession'))->first();
        return view('admin.profile_role')->with(\compact('adminRole'));
    }

    
    public function settings() 
    {
        $adminDetails = Admin::where('username', Session::get('adminSession'))->first();
        return view('admin.settings')->with(\compact('adminDetails'));
    }

    public function chkPassword(Request $request) {
         $data = $request->all();
         $current_password = $data['current_pwd'];
         $adminCount = Admin::where(['username' => Session::get('adminSession'), 'password' =>\md5( $current_password)])->count();
         if($adminCount == 1) {
             echo "true"; die;
         }else{
             echo "false"; die;
         }
    }

    public function updatePassword(Request $request) {

        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $current_password = $data['current_pwd'];
            $adminCount = Admin::where(['username' => Session::get('adminSession'), 'password' => \md5($current_password)])->count();
            if($adminCount == 1) {
                $password = md5($data['new_pwd']);
                Admin::where('username', Session::get('adminSession'))->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success','password_update_successfully');
            }else{
                return redirect('/admin/settings')->with('flash_message_error','incorrect_current_password');
            }
        }
    }

    public function logout() {
      
        Session::flush();
        return redirect('/admin')->with('flash_message_success','logged_out_successfully');
    }


    public function viewAdmins() {

        $admins = DB::table('admins')->orderBy('created_at','desc')->get();

        return view('admin.admins.view_admins')->with(\compact('admins'));
    }


    public function addAdmins(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $adminCount = DB::table('admins')->where('username',$data['username'])->count();
            if($adminCount > 1) {
                return \redirect()->back()->with('flash_message_error','Admin / Sub Admin already exists !, please chose another.');
            } else {
                if($data['type'] == "Admin") {
                    $admin = new Admin;
                    $admin->type = $data['type'];
                    $admin->username = $data['username'];
                    $admin->password = md5($data['password']);
                    $admin->status = $data['status'] ?? 0;
                    $admin->categories_view_access = 1;
                    $admin->categories_edit_access = 1;
                    $admin->categories_full_access = 1;
                    $admin->products_access = 1;
                    $admin->order_access = 1;
                    $admin->users_access =  1;
                    $admin->save();
                    return \redirect()->back()->with('flash_message_success','Admin added successfully !');

                } else if($data['type'] == "Sub Admin") {
                    if(empty($data['categories_view_access'])) {
                        $data['categories_view_access'] = 0;
                    } if(empty($data['categories_edit_access'])) {
                        $data['categories_edit_access'] = 0;
                    } if(empty($data['categories_full_access'])) {
                        $data['categories_full_access'] = 0;
                    } else {
                        if($data['categories_full_access'] == 1) {
                            $data['categories_view_access'] = 1;
                            $data['categories_edit_access'] = 1;
                        }
                    }
                    $admin = new Admin;
                    $admin->type = $data['type'];
                    $admin->username = $data['username'];
                    $admin->password = md5($data['password']);
                    $admin->categories_view_access = $data['categories_view_access'];
                    $admin->categories_edit_access = $data['categories_edit_access'];
                    $admin->categories_full_access = $data['categories_full_access'];
                    $admin->products_access = $data['products_access'] ?? 0;
                    $admin->order_access = $data['order_access'] ?? 0;
                    $admin->users_access = $data['users_access'] ?? 0;
                    $admin->status = $data['status'] ?? 0;
                    $admin->save();
                    
                    return \redirect()->back()->with('flash_message_success','Sub Admin added successfully !');
                }
            }
        }
        return \view('admin.admins.add_admins');
    }

    
    public function editAdmins($id = null, Request $request) {

        $adminDetails = DB::table('admins')->where('id',$id)->first();
        if($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            if($data['type'] == "Admin") {
                DB::table('admins')->where('username',$data['username'])->update([
                     'password' => md5($data['password']),
                     'status' => $data['status'] ?? 0,
                     'updated_at' => date('Y-m-d H:i:s')
                ]);
                return \redirect()->back()->with('flash_message_success','Admin Updated successfully !');

            } else if($data['type'] == "Sub Admin") {
                DB::table('admins')->where('username',$data['username'])->update([
                    'password' => md5($data['password']),
                    'categories_view_access' => $data['categories_view_access'] ?? 0,
                    'categories_edit_access' => $data['categories_edit_access'] ?? 0,
                    'categories_full_access' => $data['categories_full_access'] ?? 0,
                    'products_access' => $data['products_access'] ?? 0,
                    'order_access' => $data['order_access'] ?? 0,
                    'users_access' => $data['users_access'] ?? 0,
                    'status' => $data['status'] ?? 0,
                    'updated_at' => date('Y-m-d H:i:s')
               ]);                
                return \redirect()->back()->with('flash_message_success','Sub Admin updated successfully !');
            }
        }
        return view('admin.admins.edit_admins')->with(compact('adminDetails'));
    }



}