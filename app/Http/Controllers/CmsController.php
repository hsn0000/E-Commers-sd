<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use App\CmsPage;
use App\Category;
use DB;
use Date;
use Illuminate\Support\Facades\Mail;


class CmsController extends Controller
{

    public $viewdata = [];
      
    protected $mod_alias = 'cms-page';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }


    public function indexCmsPage() {
        
        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);
  
        $cmsPages = $this->query->get_cms_page()->orderByRaw('created_at DESC')->get();

        $this->viewdata['cmsPages'] = $cmsPages;
          
        $this->viewdata['toolbar'] = true;
  
        $this->viewdata['page_title'] = __('page.CMS-page');

        return view('admin.pages.view_cms_page', $this->viewdata);
    }


    public function addCmsPage(Request $request) {

        if($request->isMethod('post')) {

            $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();
           
            $request->validate([
                'title' => 'required',
                'url' => 'required',
                'description' => 'required'
            ]);

            if($this->query->get_cms_page(['title' => $data['title']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Title '.$data['title'].' has ben already exists');
            }
            elseif($this->query->get_cms_page(['url' => $data['url']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','url '.$data['url'].' has ben already exists');
            }

            $cmspage = New CmsPage;
            $cmspage->title = $data['title'];
            $cmspage->url = $data['url'];
            $cmspage->description = $data['description'];
            $cmspage->meta_title = $data['meta_title'] ?: "";
            $cmspage->meta_description = $data['meta_description'] ?: "";
            $cmspage->meta_keywords = $data['meta_keywords'] ?? "";
            $cmspage->status = $data['status'] ?? "0";
            $cmspage->save();

            return redirect($this->module->permalink)->with('msg_success','Data CMS Page has ben success save to storage');
        }

        $this->page->blocked_page($this->mod_alias, 'create');

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.add_cms_page');

        return view('admin.pages.add_cms_page', $this->viewdata);
    }


    public function editCmsPage(Request $request) {

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
            $data_id = \session('data_id');
        } 

        $cmsPage = $this->query->get_cms_page(['id' => $data_id])->first();

        $this->viewdata['cmsPage'] = $cmsPage;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.edit_banner');

        return view('admin.pages.edit_cms_page', $this->viewdata);
    }


    public function updateCmsPage(Request $request) 
    {
        $this->page->blocked_page($this->mod_alias, 'alter');

        $data = $request->all();

        $request->validate([
            'title' => 'required',
            'url' => 'required',
            'description' => 'required'
        ]);
    
        $data_id = session('data_id');

        if(!$data_id)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        if(DB::table('cms_pages')->where('title', ucwords($request->input('title')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','Title '.$data['title'].' has ben already exists');
        }
        elseif(DB::table('cms_pages')->where('url', ucwords($request->input('url')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','Url '.$data['url'].' has ben already exists');
        }

        $update = DB::table('cms_pages')->where('id',$id)->update([
            'title' => $data['title'],
            'url' => $data['url'],
            'description' => $data['description'],
            'meta_title' => $data['meta_title'] ?? '',
            'meta_description' => $data['meta_description'] ?? '',
            'meta_keywords' => $data['meta_keywords'] ?? '',
            'status' => $data['status'] ?? 0
        ]);

        if(!$update)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
        }
  
        return redirect($this->module->permalink)->with('msg_success', 'Data Cms Page '.ucwords($request->input('title')).' has been updated');
  
    }


    public function deleteCmsPage(Request $request) {

        $this->page->blocked_page($this->mod_alias,'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }
  
        $data_id = array_keys($request->input('data_id'));
  
        $CMSpage = DB::table('cms_pages')->where('id',$data_id)->first();

        $delete = DB::table('cms_pages')->where('id',$data_id)->delete();
        
        if(!$delete)
        {
            return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
        }
 
        return redirect($this->module->permalink)->with('msg_success', 'Cms Page '.$CMSpage->title.' has been deleted');
        
    }


    public function cmsPage($url) {
         
        // redirec to page 404 if CMS page is disable or does not exist
        $cmsPageCount = DB::table('cms_pages')->where(['url' => $url, 'status' => 1] )->count();
        if($cmsPageCount > 0) {
            $cmsPageDetails = DB::table('cms_pages')->where('url',$url)->first();
            // $billboard = DB::table('billboards')->inRandomOrder()->orderBy('id','DESC')->where('status',1)->offset(0)->limit(1)->get();
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();
            // meta tags
            $meta_title = $cmsPageDetails->meta_title;
            $meta_description = $cmsPageDetails->meta_description;
            $meta_keyword = $cmsPageDetails->meta_keywords;

            return view('pages.cms_page')->with(\compact('cmsPageDetails','categories','meta_title','meta_description','meta_keyword'));
        } else {
            \abort(404); 
        } 

    }


    public function contact(Request $request) {

        if($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required',
                'subject' => 'required',
                'message' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
             }
            $email = "admin.ecommerce-hsn@yopmail.com";
            $messageData = [
                'name' => $data['name'], 
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['message']
            ];
           Mail::send('emails.enquiry', $messageData, function ($message) use ($email) {
               $message->to($email)->subject('Enquiry from E-com-hsn Website');
           });

           DB::table('enquiries')->insert([
                'name' => $data['name'], 
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'created_at' => date('Y-m-d H:i:s')
           ]);

           return redirect()->back()->with('flash_message_success','Thanks for your enquiry. We will get back to you soon. ');
        }
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();
            // meta tags
            $meta_title = "Contact Us - E-commerce Website";
            $meta_description = "Contact us for any queries related to our products.";
            $meta_keyword = "contact us, queries";

        return view('pages.contact')->with(\compact('categories','meta_title','meta_description','meta_keyword'));
    }

    // public function addPost(Request $request) {
    //     if($request->isMethod('post')) {
    //         $data = $request->all();
    //         DB::table('enquiries')->insert([
    //             'name' => $data['name'],
    //             'email' => $data['email'],
    //             'subject' => $data['subject'],
    //             'message' => $data['message']
    //         ]);
    //     }
    // }


}
