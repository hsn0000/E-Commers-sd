<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;
use DB;

class UserGroupController extends Controller
{
    public $viewdata = [];
    protected $mod_alias = 'user-group';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }

    public function indexUserGroup(Request $request) {
        $this->page->blocked_page($this->mod_alias);
        \session::forget(['data_id']);

        $get_data = DB::table('user_group');

        $this->viewdata['get_data'] = $get_data;
        
        $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = __('page.user_group_title');

        return view('admin.userGroup.index_userGroup', $this->viewdata); 
    }


    public function userGroupAdd() {
        $this->page->blocked_page($this->mod_alias);

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('admin.user_group_title');
       
        return view('admin.userGroup.add_userGroup', $this->viewdata);
    }


    public function userGroupSave(Request $request) {
        $this->page->blocked_page($this->mod_alias);

        $_validates = [
            'group_name' => 'required'
        ];

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/add')
                    ->withErrors($validator)
                    ->withInput();
        }

        $_roles = null;
        if($request->filled('module'))
        {
            foreach($request->input('module') as $idx => $val ) 
            {
                $_roles[$idx] = implode(',', array_keys($val));
            }
        }

        /* check group name */ 

        $group_name = DB::table('user_group')->where(['gname' => ucwords($request->input('group_name'))])->select('gname')->count();
        if($group_name > 0 )    
        {
            return \redirect($this->module->permalink.'/add')
                    ->with('msg_error', 'Group name '.ucwords($request->input('group_name')).' already exists')
                    ->withInput();
        }    

        $_inserted = [
            'gname' =>\ucwords($request->input('group_name')),
            'roles' => json_encode($_roles),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insert = DB::table('user_group')->insertGetId($_inserted);

        if(!$insert)
        {
            return \redirect($this->module->permalink.'/add')->with('msg_error', 'Failed to insert new data to Storage')->withInput();
        }

        return \redirect($this->module->permalink)->with('msg_success','New Group '.ucwords($request->input('group_name')).' has been saved');

    }

    
    public function userGroupEdit(Request $request) {


        $this->page->blocked_page($this->mod_alias,'alter');

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
            $data_id = \session('data_id');
        } 

        /* get data by ID */ 
        $data_edit = DB::table('user_group')->where(['guid' => $data_id])->first();

        if(!isset($data_edit->gname))
        {
            return \redirect($this->module->permalink)->with('msg_error','Data id not found');
        }

        $this->viewdata['data_edit'] = $data_edit;
        $this->viewdata['toolbar_save'] = true;
        $this->viewdata['page_title'] = "Edit User Group";

        return view('admin.userGroup.edit_userGroup', $this->viewdata);
    }


    public function userGroupUpdate(Request $request) {

        $this->page->blocked_page($this->mod_alias,'alter');

        $data_id = session('data_id');

        if(!$data_id) 
        {
            return \redirect($this->module->permalink.'/edit')->with('msg_error','Data id not found');
        }

        /* get data ID */
        $data_edit = DB::table('user_group')->where(['guid' => $data_id])->first();
        
        if(!isset($data_edit->gname))
        {
            return \redirect($this->module->permalink.'/edit')->with('msg_error','Data id not found');
        }

        $_validates = [
            'group_name' => 'required'
        ];

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/edit')
            ->withErrors($validator)
            ->withInput();
        }

        $_roles = null;
        if($request->filled('module'))
        {
            foreach($request->input('module') as $idx => $val)
            {
                $_roles[$idx] = implode(',',array_keys($val));
            }
        }

        /* check exists group name */
        $group_name = DB::table('user_group')->where('gname', \ucwords($request->input('group_name')))->where('guid', '!=', $data_edit->guid)->select('gname')->count();

        if($group_name > 0 )
        {
            return \redirect($this->module->permalink.'/edit')
            ->with('msg_error', 'Group name '.\ucwords($request->input('group_name')).' already exists')
            ->withInput();
        }
        
        $_updated = [
            'gname' => \ucwords($request->input('group_name')),
            'roles' => \json_encode($_roles),
            'updated_at' =>  date('Y-m-d H:i:s')
        ];

        $update = DB::table('user_group')->where(['guid' => $data_edit->guid])->update($_updated);

        if(!$update)
        {
            return \redirect($this->module->permalink.'/edit')->with('msg_error','Failed to update data to Storage')->withInput();
        }

        return \redirect($this->module->permalink)->with('msg_success', 'Data group '.\ucwords($request->input('group_name')).' has been updated');

    }


    public function userGroupDelete(Request $request) {
        $this->page->blocked_page($this->mod_alias, 'drop');

        if(!$request->filled('data_id'))
        {
            return \redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }

        $data_id = array_keys($request->input('data_id'));

        /*get data by ID*/ 
        $data_edit = DB::table('user_group')->where(['guid' => $data_id])->first();

        if(!isset($data_edit->gname))
        {
            return \redirect($this->module->permalink)->with('msg_error','Data id not found');
        }

        /* cheking user on group */ 
        $total_user = DB::table('users')->where(['guid' => $data_edit->guid])->select('id')->count();

        if($total_user > 0 )
        {
            return \redirect($this->module->permalink)->with('msg_error','User Group '.$data_edit->gname.' have '.$total_user.' Users');
        }

        /* deleting the user group */ 
        $delete = DB::table('user_group')->where(['guid' => $data_edit->guid])->delete();

        if(!$delete)
        {
            return \redirect($this->module->permalink)->with('msg_error','Failed to delete data to Storage')->withInput();
        }

        return redirect($this->module->permalink)->with('msg_success','Data group '.$data_edit->gname.' has been deleted');

    }
    


}
