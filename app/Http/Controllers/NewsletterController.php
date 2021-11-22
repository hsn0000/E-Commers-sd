<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use DB;
use App\Exports\subscribersExport; 
use App\NewsletterSubscriber;
// use Maatwebsite\Excel\Facades\Excel;
use Excel;

class NewsletterController extends Controller
{

    public $viewdata = [];

    protected $mod_alias = 'newsletter-subscribtion';

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

    public function indexNewsletterSubscribers() {

        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);
  
        $newsletters = $this->query->get_newsletter_subscribers()->orderByRaw('created_at DESC')->get();

        $this->viewdata['newsletters'] = $newsletters;
          
        $this->viewdata['toolbar'] = true;
  
        $this->viewdata['page_title'] = __('page.newsletters');

        return \view('admin.newsletters.view_newsletters',$this->viewdata);
    }


    public function editStatusNewsletter(Request $request) {

        $this->page->blocked_page($this->mod_alias,'alter');

        if($request->ajax()) {
            $dataId = $request['id'];
            $whereStatus = DB::table('newsletter_subscribers')->where('id', $dataId)->select('status')->get();
            if($whereStatus['0']->status === 1) {
                DB::table('newsletter_subscribers')->where('id', $dataId)->update(['status' => 0]);
                return "success1";
            } else if ($whereStatus['0']->status === 0) {
                DB::table('newsletter_subscribers')->where('id', $dataId)->update(['status' => 1]);
                return "success0";
            }
            // return $whereStatus['0']->status;
        }
    }


    public function deleteNewsletterEmail(Request $request) {

        $this->page->blocked_page($this->mod_alias,'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }
  
        $data_id = array_keys($request->input('data_id'));
  
        $newsletter = DB::table('newsletter_subscribers')->where('id',$data_id)->first();
  
        $delete = DB::table('newsletter_subscribers')->where('id',$data_id)->delete();

        if(!$delete)
        {
            return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
        }
 
        return redirect($this->module->permalink)->with('msg_success', 'Newsletter '.$newsletter->email.' has been deleted');
        
    }


    public function exportNewsletterEmail() {

        $this->page->blocked_page($this->mod_alias,'alter');

        return Excel::download(new subscribersExport, 'subscribers.xlsx');
    }


    // public function exportNewsletterEmail() {
    //     $subscribersData = DB::table('newsletter_subscribers')->select('id', 'email', 'created_at')->where('status',1)->orderBy('id','Desc')->get();
    //     $subscribersData = json_decode(\json_encode($subscribersData),true);
    //     return Excel::create('subscriber'.rand(), function($excel) use($subscribersData) {
    //         $excel->sheet('mySheet', function($sheet) use ($subscribersData) {
    //             $sheet->fromArray($subscribersData);
    //         });
    //     })->download('xlxs');
        // dd($subscribersData);
        // return view('admin.newsletters.export.excel_newsletter')->with(compact('subscribersData'));
    // }


    /*
        front
    */ 
    public function addSubscriber(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            $subscriberCount = DB::table('newsletter_subscribers')->where('email', $data['subscriber_email'])->count();
            if($subscriberCount > 0) {
                echo print"exists";
            } else {
                // add newsleter email
                DB::table('newsletter_subscribers')->insert([
                    'email' => $data['subscriber_email'],
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                echo print"save";
            }
            //  echo "<pre>"; print_r($data['subscriber_email']);
        }
    }

      
    public function checkSubscriber(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            $subscriberCount = DB::table('newsletter_subscribers')->where('email', $data['subscriber_email'])->count();
            if($subscriberCount > 0) {
                echo print"exists";
            }
            //  echo "<pre>"; print_r($data['subscriber_email']);
        }
    }

// a

}
  