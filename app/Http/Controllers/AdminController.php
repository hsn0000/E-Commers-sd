<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Storage;

use Illuminate\Support\Arr;

use Session;
use App\User;
use App\Admin;
use DB;
// use Date;
use Image;

use Jenssegers\Date\Date;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Html\Builder;

use App\Model\PageModel;
use App\Model\QueryModel;

class AdminController extends Controller
{

    public $viewdata = [];

    protected $mod_alias ='user-admin';

    public function __construct()
    {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;

        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;

        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;

    }


    public function login(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->input();
            $adminCount = User::where('name', $data['username'])->where('password',md5($data['password']), ['status'=>1])->where(['admin' => 1])->count();

            if($adminCount > 0) {

                $admin_detail = $this->query->get_user(['u.name' => $data['username']])->first();

                $admin_id =  $admin_detail->id;
                $admin_guid = $admin_detail->guid;

                Session::put('adminID', $admin_id);
                Session::put('adminSession', $data['username']);

                /*loro*/ 
                session([
                    'session_uid' => $admin_id,
                    'session_guid' => $admin_guid,
                ]);
                /*^*/

                return redirect('/admin/dashboard');

            }else{
                
                return redirect('/admin')->with('flash_message_error','invalid_username_or_password');
            }
        }

        return view('admin.admin_login'); 
    }


    public function profileRole()
    {
        $adminRole = User::where('name', Session::get('adminSession'))->where('admin', 1)->where('status', 1)->first();
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



    public function editStatusAdmins(Request $request) {
        if($request->ajax()) {
            $dataId = $request['id'];
            $whereStatus = DB::table('users')->where('id', $dataId)->select('status')->get();
            if($whereStatus['0']->status === 1) {
                DB::table('users')->where('id', $dataId)->update(['status' => 0]);
                return "success1";
            } else if ($whereStatus['0']->status === 0) {
                DB::table('users')->where('id', $dataId)->update(['status' => 1]);
                return "success0";
            }
      
        }
    }


    /*
        NEW NORMALLLL !!  
    */ 


    public function indexUserAdmin(Builder $builder) {
        $this->page->blocked_page($this->mod_alias);

        // $builder->ajax([
        //     'url' => route('userAdmin.dataTable'),
        //     'type' => 'post',
        //     'autowidth' => true,
        //     'data' => ['_token' => csrf_token()]
        // ]);

        // if($this->page->fetch_role('alter', $this->module) == true || $this->page->fetch_role('drop', $this->module) == true)
        // {
        //     $colomns = [
        //         ['data' => 'checkbox', 'render' => "'<div class=\"checkbox\"><input type=\"checkbox\" class=\"checkbox__input child-check\" id=\"child-'+full.id+'\" name=\"data_id['+full.id+']\"><label class=\"checkbox__label\" for=\"child-'+full.id+'\">&nbsp;</label></div>'",'title' => '<div class="checkbox"><input type="checkbox" class="checkbox__input main-check" id="main-check-top"><label class="checkbox__label" for="main-check-top">&nbsp;</label></div>', 'footer' => '<div class="checkbox"><input type="checkbox" class="checkbox__input main-check" id="main-check-bottom"><label class="checkbox__label" for="main-check-bottom">&nbsp;</label></div>', 'style' => 'width:5%', 'orderable' => FALSE, 'searchable' => FALSE]
        //     ];
        // }
        // else 
        // {
        //     $colomns = [
        //         ['data' => 'no', 'title' => '#', 'footer' => '#']
        //     ];
        // }

        // $colomns = array_push_multidimension($colomns, [
        //     ['data' => 'name', 'title' => 'Name', 'footer' => 'Name', 'render' => "data+(full.email?'<small class=\"form-text text-muted\">'+full.email+'</small>':'')" ],
        //     ['data' => 'gname', 'title' => 'Group', 'footer' => 'Group'],
        //     ['default_content' => NULL, 'title' => 'Status', 'footer' => 'Status', 'render' => "$('<span/>').html(full.active).text()"],
        //     ['data' => 'join_date', 'title' => 'Created', 'footer' => 'Created', 'render' => "data+(full.updated?'<small class=\"form-text text-muted\">Updated : '+full.updated+'</small>':'')"]
        // ]);

        // $html = $builder->columns($colomns);

        $get_table = $this->query->get_user(session('session_guid') > 1 ? ['u.guid' => session('session_guid')] : "");

        $_data_table = [];

        if($get_table->count() > 0 )
        {
            foreach($get_table->get() as $key => $val )
            {
                $_active = null;
                if($val->status > 0 )
                {
                    $_active = '<span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> Yes</span>';
                }
                else 
                {
                    $_active = '<span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> No</span>';
                }

                $_data_table[] = [
                    'no' => ++$key,
                    'id' => $val->id,
                    'name' => $val->name,
                    'email' => $val->email,
                    'guid' => $val->guid,
                    'gname' => $val->gname,
                    'status' => $_active,
                    'join_date' => Date::parse($val->created_at)->format('l, j F Y - H:i A'),
                    'updated' => $val->updated_at ? Date::parse($val->updated_at)->format('l, j F Y - H:i A') : NULL
                ];

            }
        }

        $this->viewdata['data_table'] = $_data_table;

        session()->forget(['data_id']);

        $this->viewdata['page_title'] = __('admin.user_title');

        $this->viewdata['toolbar'] = true;

        return view('admin.admins.user_admin.index_userAdmin', $this->viewdata);

    }


    public function dataTable(Request $request) {
        $this->page->blocked_page($this->mod_alias);

        $get_table = $this->query->get_user(session('session_guid') > 1 ? ['u.guid' => session('session_guid')] : "");

        $_data_table = [];

        if($get_table->count() > 0 )
        {
            foreach($get_table->get() as $key => $val )
            {
                $_active = null;
                if($val->status > 0 )
                {
                    $_active = '<span class="badge badge-pill badge-primary" style="margin-right: 10px;"><i class="zwicon-checkmark"></i> Yes</span>';
                }
                else 
                {
                    $_active = '<span class="badge badge-pill badge-danger" style="margin-right: 10px;"><i class="zwicon-close"></i> No</span>';
                }

                $_data_table[] = [
                    'no' => ++$key,
                    'id' => $val->id,
                    'name' => $val->name,
                    'email' => $val->email,
                    'guid' => $val->guid,
                    'gname' => $val->gname,
                    'status' => $_active,
                    'join_date' => Date::parse($val->created_at)->format('l, j F Y - H:i A'),
                    'updated' => $val->updated_at ? Date::parse($val->updated_at)->format('l, j F Y - H:i A') : NULL
                ];

            }
        }

        return datatables()->of($_data_table)
        ->filter(function($instance) use ($request){
            if ($request->has('search.value') && !empty($request->input('search.value'))) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                    if(Str::contains($row['name'], Str::title($request->input('search.value'))))
                    {
                        return true;
                    }
                    else
                    if(Str::contains($row['gname'], Str::title($request->input('search.value'))))
                    {
                        return true;
                    }

                    return false;
                });
            }
        })
        ->make(true);;

    }


    public function addUserAdmin() {
        $this->page->blocked_page($this->mod_alias, 'create');

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.user_title');

        return view('admin.admins.user_admin.add_userAdmin', $this->viewdata);
    }


    public function saveUserAdmin(Request $request) {
        $this->page->blocked_page($this->mod_alias, 'create');

        $_validates = [
            'username' => 'required',
            'password' => 'required',
            'repassword' => 'required',
            'email' => 'required'
        ];

        if(session('session_guid') == 1 )
        {
            $_validates = array_push_multidimension($_validates, [
                'user_group' => 'required'
            ]);
        }

        // if(session('session_guid') > 1 )
        // {
        //     $_validates = array_push_multidimension($_validates, [
        //         'employee' => 'required'
        //     ]);
        // }

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/add')
            ->withErrors($validator)
            ->withInput();
        }

        /*
            check exists user name
        */ 
        $username = DB::table('users')->where('name', Str::slug($request->input('username'), '_'))->select('name')->count();
     
        if($username > 0 )
        {
            return redirect($this->module->permalink.'/add')
            ->with('msg_error', 'Username '.Str::slug($request->input('username'), '_').' already exists')
            ->withInput();
        }

        if($request->filled('password') && $request->input('password') !== $request->input('repassword'))
        {
            return redirect($this->module->permalink.'/add')
            ->with('msg_error', 'Password does not match')
            ->withInput();
        }

        /*
            check user employee if exists
        */ 
        // if(session('session_guid') > 1 )
        // {
        //     $user_employee = DB::table('users AS u')->where(['employee_id' => $request->input('employee')])->leftJoin('employee AS e', 'e.id', '=', 'u.employee_id')->select('e.fullname');

        //     if($user_employee->count() > 0 )
        //     {
        //         return redirect($this->module->permalink.'/add')
        //         ->with('msg_error', 'Employee '.$user_employee->first()->fullname.' have user account already')
        //         ->withInput();
        //     }
        // }

        $_inserted = [
            'guid' => session('session_guid') > 1 ? $this->page->user_data()->guid : $request->input('user_group'),
            'employee_id' => session('session_guid') > 1 ? $request->input('employe') : null,
            'name' => Str::slug($request->input('username'), '_'),
            'email' => $request->input('email'),
            'password' => md5($request->input('password')),
            'admin' => 1,
            'status' => $request->input('active') == 'on' ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ]; 

        $insertID = DB::table('users')->insertGetId($_inserted);

        if(!$insertID)
        {
            return \redirect($this->module->permalink.'/add')
            ->with('msg_error','Failed to insert new data to storage')
            ->withInput();
        }

        DB::table('users_biodata')->insert(['user_id' => $insertID,'mobile' =>  $request->input('phone') ?? null, 'address' => null, 'city' => null,'state' => null, 'country' => null, 'pincode' => null ]);

        return redirect($this->module->permalink)->with('msg_success', 'New user '.Str::slug($request->input('username'), '_').' has been saved');

    }


    public function editUserAdmin(Request $request) {
        $this->page->blocked_page($this->mod_alias, 'alter');

        if(!$request->filled('data_id') && !session('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error','Data id not found');
        }

        if(!session('data_id'))
        {
            $data_id = array_keys($request->input('data_id'));
            $data_id = $data_id[0];
            session(['data_id' => $data_id]);
        }
        else
        {
            $data_id = session('data_id');
        }

        /*
            get data by ID 
        */
        $data_edit = DB::table('users AS u')
        ->leftJoin('users_biodata AS ub', 'u.id', '=', 'ub.user_id')
        ->selectRaw('u.*, ub.mobile')
        ->where(['u.id' => $data_id])->first();
        
        if(!isset($data_edit->name))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }

        $this->viewdata['data_edit'] = $data_edit;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.user_title');

        return view('admin.admins.user_admin.edit_userAdmin', $this->viewdata);

    }


    public function updateUserAdmin(Request $request) {
        $this->page->blocked_page($this->mod_alias, 'alter');

        $data_id = session('data_id');

        if(!$data_id)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        /*
            get data by ID 
        */
        $data_edit = DB::table('users AS u')
        ->leftJoin('users_biodata AS ub', 'u.id', '=', 'ub.user_id')
        ->selectRaw('u.*, ub.mobile')
        ->where(['u.id' => $data_id])->first();

        if(!isset($data_edit->name))
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        $_validates = [
            'email' => 'required'
        ];

        if(session('session_guid') == 1)
        {
            $_validates = array_push_multidimension($_validates, [
                'user_group' => 'required'
            ]);
        }

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return redirect($this->module->permalink.'/edit')
            ->withErrors($validator)
            ->withInput();
        }

        /*
           Check exists user name
        */

        $username = DB::table('users')->where('name', Str::slug($request->input('username'), '_'))->where('id', '!=', $data_edit->id)->select('name')->count();

        if($username > 0 )
        {
            return redirect($this->module->permalink.'/edit')
            ->with('msg_error', 'Username '.Str::slug($request->input('username'), '_').' already exists')
            ->withInput();
        }

        $_updated = [
            'guid' => session('session_guid') > 1 ? $this->page->user_data()->guid : $request->input('user_group'),
            'name' => Str::slug($request->input('username'), '_'),
            'email' => $request->input('email'),
            'admin' => 1,
            'status' => $request->input('active') == 'on' ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $update = DB::table('users')->where(['id' => $data_edit->id])->update($_updated);

        if(!$update)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
        }

        $_userbio = DB::table('users_biodata')->where('user_id', $data_id)->count();
       
        if($_userbio > 0 )
        {
            DB::table('users_biodata')->where('user_id', $data_id)->update(['mobile' =>  $request->input('phone') ?? null]);
        } else {
            DB::table('users_biodata')->insert(['user_id' => $data_id,'mobile' =>  $request->input('phone') ?? null, 'address' => null, 'city' => null,'state' => null, 'country' => null, 'pincode' => null ]);
        }

        return redirect($this->module->permalink)->with('msg_success', 'Data user '.Str::slug($request->input('username'), '_').' has been updated');
        
    }

    
    public function deleteUserAdmin(Request $request) {
        $this->page->blocked_page($this->mod_alias, 'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }

        $data_id = array_keys($request->input('data_id'));

        /*
           Get Data by ID
        */
        $data_edit = DB::table('users AS u')
        ->leftJoin('users_biodata AS ub', 'u.id', '=', 'ub.user_id')
        ->selectRaw('u.*, ub.mobile')
        ->where(['u.id' => $data_id])->first();

        if(!isset($data_edit->name))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }

        /*
          Deleting the User Group
        */

        $delete = DB::table('users')->where(['id' => $data_id])->delete();

        if(!$delete)
        {
            return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
        }

        if( DB::table('users_biodata')->where('user_id', $data_id)->count() > 1 )
        {
            DB::table('users_biodata')->where('user_id', $data_id)->delete();
        }

        return redirect($this->module->permalink)->with('msg_success', 'Data user '.$data_edit->name.' has been deleted');

    }

    /*
       END NEW NORMALLLL !!  
    */ 




}