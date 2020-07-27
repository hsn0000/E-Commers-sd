<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Storage;

use Illuminate\Support\Arr;

use App\Model\PageModel;
use App\Model\QueryModel;

use DB;
use Session;

class ProfileUserAdminController extends Controller
{
    public $viewdata = [];

    protected $mod_alias ='profile-user-admin';

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


    public function profileRole()
    {
        $this->page->blocked_page($this->mod_alias);

        $adminRole = $this->query->get_data_users_front(['name' =>   Session::get('adminSession')])->first();
       
        $this->viewdata['adminRole'] = $adminRole;

        return view('admin.profile_role', $this->viewdata);
    }


    public function settings() 
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
      
        $adminDetails = $this->query->get_data_users_front(['name' =>   Session::get('adminSession')])->first();

        $this->viewdata['adminDetails'] = $adminDetails;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.Settings');

        return view('admin.settings', $this->viewdata);
    }


    public function chkPassword(Request $request) {

        $this->page->blocked_page($this->mod_alias, 'alter');

        $data = $request->all();

        $current_password = $data['current_pwd'];

        $adminCount = $this->query->get_data_users_front( ['name' => Session::get('adminSession')])->where(['password' =>\md5( $current_password)])->count();
        
        if($adminCount == 1) {
            echo "true"; die;
        }else{
            echo "false"; die;
        }
   }


   public function updatePassword(Request $request) {
    
        $this->page->blocked_page($this->mod_alias, 'alter');

        if($request->isMethod('post')) {

            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $current_password = $data['current_pwd'];

            $adminCount = $this->query->get_data_users_front( ['name' => Session::get('adminSession')])->where(['password' =>\md5( $current_password)])->count();
           
            if($adminCount == 1) {
                $password = md5($data['new_pwd']);
                DB::table('users')->where('name', Session::get('adminSession'))->update(['password'=>$password]);
                return redirect($this->module->permalink.'/settings')->with('msg_success','password_update_successfully');
            }else{
                return redirect($this->module->permalink.'/settings')->with('msg_error','incorrect_current_password');
            }
        }
    }



}
