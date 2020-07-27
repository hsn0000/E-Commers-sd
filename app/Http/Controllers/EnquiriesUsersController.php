<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use DB;

class EnquiriesUsersController extends Controller
{
    public $viewdata = [];
      
    protected $mod_alias = 'inquiries';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }


    public function indexInquiries() {

        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);
  
        $enquiriesList = $this->query->get_enquiries()->orderByRaw('created_at DESC')->get();

        $this->viewdata['enquiriesList'] = $enquiriesList;
          
        $this->viewdata['toolbar'] = true;
  
        $this->viewdata['page_title'] = __('page.inquiries');

        return view('admin.enquiries.enquiries_list',$this->viewdata);
    }


    public function deleteEnquiriesUsers($id = null) {

        $this->page->blocked_page($this->mod_alias,'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }
  
        $data_id = array_keys($request->input('data_id'));
  
        $enquiries = DB::table('enquiries')->where('id',$data_id)->first();

        $delete = DB::table('enquiries')->where('id', $$data_id)->delete();

       if(!$delete)
       {
           return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
       }

       return redirect($this->module->permalink)->with('msg_success', 'Banners '.$enquiries->email.' has been deleted');
       
    }

    
    public function enquiriesOutbox() {
        \abort(404);
    }

}
