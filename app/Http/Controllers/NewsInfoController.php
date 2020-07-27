<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use DB;
use Session;

class NewsInfoController extends Controller
{
    public $viewdata = [];
      
    protected $mod_alias = 'news-information';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }
    
    public function indexNews() {

        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);
  
        $newsInfoAll =$this->query->get_news_info()->orderByRaw('updated_at DESC')->get();

        $this->viewdata['newsInfoAll'] = $newsInfoAll;
          
        $this->viewdata['toolbar'] = true;
  
        $this->viewdata['page_title'] = __('page.news-information');

        return view('admin.newsInfo.view_news',$this->viewdata);
    }


    public function addNews(Request $request) {

        if($request->isMethod('post')) {
            $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();

            $request->validate([
                'description' => 'bail|required|',
                'url' => 'required'
            ]);

            if($this->query->get_news_info(['url' => $data['url']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Url News Info '.$data['url'].' has ben already exists');
            }

           $insert = DB::table('news_info')->insert([
                'description' => $data['description'],
                'url' => $data['url'],
                'status' => $data['status'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if(!$insert)
            {
                return redirect($this->module->permalink.'/add')->with('msg_error', 'Failed to update data to Storage')->withInput();
            }
  
            return redirect($this->module->permalink)->with('msg_success', 'News Info Url '.ucwords($request->input('url')).' has been saved to storage');
      
        }

        $this->page->blocked_page($this->mod_alias, 'create');

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.add_news_info');

        return view('admin.newsinfo.add_news', $this->viewdata);
    }


    public function editNews(Request $request, $id = null) {

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

        $newsDetail = DB::table('news_info')->where('id',$data_id)->first();

        $this->viewdata['newsDetail'] = $newsDetail;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.edit_news_info');

        return view('admin.newsInfo.edit_news', $this->viewdata);
    }


    public function updateNews(Request $request) 
    {
        $this->page->blocked_page($this->mod_alias, 'alter');

        $data = $request->all();

        $request->validate([
            'description' => 'bail|required|',
            'url' => 'required|',
        ]);

        $data_id = session('data_id');

        if(!$data_id)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        if(DB::table('news_info')->where('url', ucwords($request->input('url')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','Url '.$data['url'].' has ben already exists');
        }
        
        $update = DB::table('news_info')->where('id',$data_id)->update([
            'description' => $data['description'],
            'url' => $data['url'],
            'status' => $data['status'] ?? 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if(!$update)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
        }
  
        return redirect($this->module->permalink)->with('msg_success', 'Data News Info '.ucwords($request->input('url')).' has been updated');
        
    }


    public function deleteNews(Request $request)
    {
        $this->page->blocked_page($this->mod_alias,'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }

        $data_id = array_keys($request->input('data_id'));
  
        $news_info = DB::table('news_info')->where('id',$data_id)->first();

        $delete = DB::table('news_info')->where('id',$data_id)->delete();

        if(!$delete)
        {
            return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
        }
 
        return redirect($this->module->permalink)->with('msg_success', 'News Information '.$news_info->url.' has been deleted');
       
    }


    public function editStatusNews(Request $request) {

        $this->page->blocked_page($this->mod_alias,'alter');

        if($request->ajax()) {
            $dataId = $request['id'];
            $whereStatus = DB::table('news_info')->where('id', $dataId)->select('status')->get();
            if($whereStatus['0']->status === 1) {
                DB::table('news_info')->where('id', $dataId)->update(['status' => 0]);
                return "success1";
            } else if ($whereStatus['0']->status === 0) {
                DB::table('news_info')->where('id', $dataId)->update(['status' => 1]);
                return "success0";
            }
            // return $whereStatus['0']->status;
        }
    }


    public function topageurlNews($id = null) {
        \abort(404);
    }


}
