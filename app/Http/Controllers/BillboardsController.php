<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use Image;
use Date; 
use DB;
use Illuminate\Support\Facades\Storage;

class BillboardsController extends Controller
{
    public $viewdata = [];
      
    protected $mod_alias = 'billboard';

    public function __construct() {

        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;

        $this->viewdata['url_amazon'] = 'https://'. env('AWS_BUCKET') .'.s3-'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/';
    }


    public function indexBillboard() {

        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);

        $billboard = $this->query->get_billboards()->orderByRaw('created_at DESC')->get();

        $this->viewdata['billboard'] = $billboard;
        
        $this->viewdata['toolbar'] = true;
  
        $this->viewdata['page_title'] = __('page.billboard');

        return view('admin.billboards.view_billboard',$this->viewdata);
    }


    public function addBillboard (Request $request) {

        if($request->isMethod('post'))
        {
            $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();

            $_validates = [
              'title' => 'required',
              'link' => 'required',
            ];
    
            $validator = Validator::make($request->all(), $_validates);
    
            if($validator->fails())
            {
                return \redirect($this->module->permalink.'/add')
                        ->withErrors($validator)
                        ->withInput();
            }

            if(!$request->hasFile('image'))
            {
                return \redirect($this->module->permalink.'/add')->with('msg_error','Image is not empty !');
            }

            if($this->query->get_billboards(['title' => $data['title']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Title '.$data['title'].' has ben already exists');
            }
            elseif($this->query->get_billboards(['link' => $data['link']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Link '.$data['link'].' has ben already exists');
            }

            if($request->hasFile('image'))
            {
                $files = $request->file('image');
                // upload image after resize 
                $extension = $files->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                // $billboard_patch = 'images/backend_images/banners/'.$filename;
                // Image::make($files)->resize(260, 377)->save($billboard_patch);
                $_images_bill = Image::make($files)->resize(260, 377)->encode($extension);
                Storage::disk('s3')->put('billboard/images/'.$filename, (string)$_images_bill);
                // Storage::disk('s3')->put('billboard/images/'.$filename, file_get_contents($files));
            }
          
            $insert = DB::table('billboards')->insert([
                'image' => $filename,
                'title' => $data['title'],
                'link' => $data['link'],
                'status' => $data['status'] ?? 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if(!$insert)
            {
                return redirect($this->module->permalink.'/add')->with('msg_error', 'Failed to update data to Storage')->withInput();
            }

            return redirect($this->module->permalink)->with('msg_success','billboard_image_has_ben_added_successfully');
        }
        
        $this->page->blocked_page($this->mod_alias, 'create');

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.add_billboard');

        return view('admin.billboards.add_billboard', $this->viewdata);
    }


    public function editBillboard(Request $request) {

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

        $billboard = DB::table('billboards')->where('id',$data_id)->first();

        $this->viewdata['billboard'] = $billboard;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.edit_billboard');

        return view('admin.billboards.edit_billboard', $this->viewdata);
    }


    public function updateBillboard(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');

        $data = $request->all();
  
        $_url_amazon = 'https://'. env('AWS_BUCKET') .'.s3-'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/';
        
        $_validates = [
          'title' => 'required',
          'link' => 'required',
        ];

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/edit')
                    ->withErrors($validator)
                    ->withInput();
        }

        $data_id = session('data_id');

        if(!$data_id)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        if(DB::table('billboards')->where('title', ucwords($request->input('title')))->where('id', '!=', $data_id)->count() > 0)
        {
            return \redirect($this->module->permalink.'/edit')->with('msg_error','Title '.$data['title'].' has ben already exists');
        }
        elseif(DB::table('billboards')->where('link', ucwords($request->input('link')))->where('id', '!=', $data_id)->count() > 0)
        {
            return \redirect($this->module->permalink.'/edit')->with('msg_error','Link '.$data['link'].' has ben already exists');
        }

        $data_edit = DB::table('billboards')->where('id', $data_id)->first();

        $data = $request->all();
      
        if($request->hasFile('image'))
        {
            $files = $request->file('image');
            // upload image after resize 
            $extension = $files->getClientOriginalExtension();

            $filename = rand(111,99999).'.'.$extension;

            $billboard_patch = 'images/backend_images/banners/'.$filename;
            // Image::make($files)->resize(260, 377)->save($billboard_patch);
            if(\file_exists($billboard_patch.$data_edit->image))
            {
                \unlink($billboard_patch.$data_edit->image);
            }
            else if(!empty($_url_amazon.'billboard/images/'.$data_edit->image))
            {
                Storage::disk('s3')->delete('billboard/images/' . $data_edit->image);
            }

            $_images_bill = Image::make($files)->resize(260, 377)->encode($extension);

            Storage::disk('s3')->put('billboard/images/'.$filename, (string)$_images_bill);
        }
        
        if(!empty($filename)) {
            $image = $filename;
        } else {
            $image = $request['current_image'];
        }

       $update = DB::table('billboards')->where('id',$data_id)->update([
            'image' => $image,
            'title' => $request['title'],
            'link' => $request['link'],
            'status' => $request['status'] ?: 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if(!$update)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
        }
  
        return redirect($this->module->permalink)->with('msg_success', 'Data Billboard '.ucwords($request->input('title')).' has been updated');
  
    }


    public function deleteBillboard(Request $request) {

        $this->page->blocked_page($this->mod_alias,'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }
  
        $data_id = array_keys($request->input('data_id'));

        $_url_amazon = 'https://'. env('AWS_BUCKET') .'.s3-'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/';

        $billboard = DB::table('billboards')->where('id',$data_id)->first();

        $billboard_patch = 'images/backend_images/banners/';

        if(!empty($billboard->image))
        {
            // Delete large image if not exist folder
            if(\file_exists($billboard_patch.$billboard->image))
            {
                \unlink($billboard_patch.$billboard->image);
            }
            else if (!empty($_url_amazon.'billboard/images/'.$billboard->image))
            {
                Storage::disk('s3')->delete('billboard/images/' . $billboard->image);
            }
        }

        $delete = DB::table('billboards')->where('id',$data_id)->delete();

        if(!$delete)
        {
            return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
        }
 
        return redirect($this->module->permalink)->with('msg_success', 'Billboard '.$billboard->title.' has been deleted');
        
    }


}
