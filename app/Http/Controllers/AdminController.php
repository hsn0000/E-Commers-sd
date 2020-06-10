<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\User;
use App\Admin;
use DB;
use Date;
use Image;
use \Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->input();
            $adminCount = User::where('name', $data['username'])->where('password',md5($data['password']), ['status'=>1])->where(['admin' => 1])->count();

            if($adminCount > 0) {
                $admin_id = DB::table('users')->where('name', $data['username'])->where('admin',1)->where('status',1)->select('id')->first(); 
                $admin_id =  $admin_id->id;

                Session::put('adminID', $admin_id);
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
        $adminRole = users::where('name', Session::get('adminSession'),'admin',1)->first();
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
                /* upload image */
                if($request->hasFile('avatar'))
                {
                    $image_tmp = $data['avatar'];
                    if($image_tmp->isValid()) 
                    {
                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extension;
                        $medium_image_path = 'images/backend_images/avatar/'.$filename;
                        // resize image
                        Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                        // storage avatar name in admin table, $filename;
                    }   
                }
                $filename = isset($filename) ? $filename : "";
                if($data['type'] == "Admin") {
                    $admin = new Admin;
                    $admin->type = $data['type'];
                    $admin->avatar = $filename;
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
                    $admin->avatar = $filename;
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
            /* upload image */
            if($request->hasFile('avatar'))
            {
                $image_tmp = $data['avatar'];
                if($image_tmp->isValid()) 
                {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $medium_image_path = 'images/backend_images/avatar/'.$filename;
                    // resize image
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    // storage avatar name in admin table, $filename;
                }   
            }

            if($data['type'] == "Admin") {
                DB::table('admins')->where('username',$data['username'])->update([
                     'password' => md5($data['password']),
                     'avatar' => $filename ?? $adminDetails->avatar ?? "",
                     'status' => $data['status'] ?? 0,
                     'updated_at' => date('Y-m-d H:i:s')
                ]);
                return \redirect()->back()->with('flash_message_success','Admin Updated successfully !');

            } else if($data['type'] == "Sub Admin") {
                DB::table('admins')->where('username',$data['username'])->update([
                    'password' => md5($data['password']),
                    'avatar' => $filename ?? $adminDetails->avatar ?? "",
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


    public function deleteAdmins($id = null) {
        $adminsDetails = DB::table('admins')->where('id',$id)->first();
        // Delete image if not exist folder
        $medium_image_patch = 'images/backend_images/avatar/';
        $avatarRoute = $adminsDetails->avatar == "" ? "kosong.png" : $adminsDetails->avatar;
        if(\file_exists($medium_image_patch.$avatarRoute))
        {
            \unlink($medium_image_patch.$avatarRoute);
        } 
        DB::table('admins')->where('id',$id)->delete();

        return \redirect()->back()->with('flash_message_success','Admin Deleted successfully !');
    }


    public function editStatusAdmins(Request $request) {
        if($request->ajax()) {
            $dataId = $request['id'];
            $whereStatus = DB::table('admins')->where('id', $dataId)->select('status')->get();
            if($whereStatus['0']->status === 1) {
                DB::table('admins')->where('id', $dataId)->update(['status' => 0]);
                return "success1";
            } else if ($whereStatus['0']->status === 0) {
                DB::table('admins')->where('id', $dataId)->update(['status' => 1]);
                return "success0";
            }
      
        }
    }



}