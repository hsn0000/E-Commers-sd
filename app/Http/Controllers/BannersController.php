<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;
use DB;

use Image;
use App\Banner;
use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{

    public $viewdata = [];
      
    protected $mod_alias = 'banner';

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


    public function indexBanners()
    {
      $this->page->blocked_page($this->mod_alias);
 
      \session::forget(['data_id']);

      $banners = $this->query->get_banners()->orderByRaw('created_at DESC')->get();

      $this->viewdata['banners'] = $banners;
        
      $this->viewdata['toolbar'] = true;

      $this->viewdata['page_title'] = __('page.banner');

      return \view('admin.banners.view_banner', $this->viewdata);

    }


    public function addBanner(Request $request) 
    {
        if($request->isMethod('post'))
        {
          $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();

            $_validates = [
              'image' => 'required',
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

            if($this->query->get_banners(['title' => $data['title']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Title '.$data['title'].' has ben already exists');
            }
            elseif($this->query->get_banners(['link' => $data['link']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Link '.$data['link'].' has ben already exists');
            }

            $banner = new Banner;

            if($request->hasFile('image'))
            {
              $files = $request->file('image');
              // upload image after resize 
              $extension = $files->getClientOriginalExtension();

              $filename = rand(111,99999).'.'.$extension;
              // $banner_patch = 'images/backend_images/banners/'.$filename;
              // Image::make($files)->resize(1140, 340)->save($banner_patch);
              $_images_bill = Image::make($files)->resize(1140, 340)->encode($extension);

              Storage::disk('s3')->put('banners/images/'.$filename, (string)$_images_bill);

              $banner->image = $filename;
              
            } 

            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->status = $data['status'] ?? 0;
            $banner->save();

          return redirect($this->module->permalink)->with('msg_success','Data Banners '.$data['title'].' has ben success save to storage');
        }

        $this->page->blocked_page($this->mod_alias, 'create');

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.add_banner');

        return view('admin.banners.add_banner', $this->viewdata);
    }


    public function editBanner(Request $request)
    {
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

        $bannerDetails = $this->query->get_banners(['id' => $data_id])->first();

        $this->viewdata['bannerDetails'] = $bannerDetails;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.edit_banner');
 
        return view('admin.banners.edit_banner', $this->viewdata);
    }


    public function updateBanner(Request $request)
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

      if(DB::table('banners')->where('title', ucwords($request->input('title')))->where('id', '!=', $data_id)->count() > 0)
      {
        return \redirect($this->module->permalink.'/edit')->with('msg_error','Title '.$data['title'].' has ben already exists');
      }
      elseif(DB::table('banners')->where('link', ucwords($request->input('link')))->where('id', '!=', $data_id)->count() > 0)
      {
        return \redirect($this->module->permalink.'/edit')->with('msg_error','Link '.$data['link'].' has ben already exists');
      }

      $data_edit = DB::table('banners')->where('id', $data_id)->first();

      if($request->hasFile('image'))
      {
          $files = $request->file('image');
          // upload image after resize 
          $extension = $files->getClientOriginalExtension();

          $filename = rand(111,99999).'.'.$extension;

          $banner_patch = 'images/backend_images/banners/'.$filename;
          // Image::make($files)->resize(1140, 340)->save($banner_patch);
          if(\file_exists($banner_patch.$data_edit->image))
          {
              \unlink($banner_patch.$data_edit->image);
          }
          else if(!empty($_url_amazon.'banners/images/'.$data_edit->image))
          {
              Storage::disk('s3')->delete('banners/images/' . $data_edit->image);
          }

          $_images_bill = Image::make($files)->resize(1140, 340)->encode($extension);

          Storage::disk('s3')->put('banners/images/'.$filename, (string)$_images_bill);
      }
      
      $update = Banner::where('id',$data_id)->update([
          'image' => $filename ?? $data['oldImage'],
          'title' => $data['title'],
          'link' => $data['link'],
          'status' => $data['status'] ?? "0",
      ]);

      if(!$update)
      {
          return redirect($this->module->permalink.'/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
      }

      return redirect($this->module->permalink)->with('msg_success', 'Data Banners '.ucwords($request->input('title')).' has been updated');

    }


    public function deleteBanner(Request $request)
    {

      $this->page->blocked_page($this->mod_alias,'drop');

      if(!$request->filled('data_id'))
      {
          return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
      }

      $data_id = array_keys($request->input('data_id'));

      $banner = DB::table('banners')->where('id',$data_id)->first();

      $_url_amazon = 'https://'. env('AWS_BUCKET') .'.s3-'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/';

      $banner_patch = 'images/backend_images/banners/';
      
      if(!empty($banner->image))
      {
        // Delete large image if not exist folder
        if(\file_exists($banner_patch.$banner->image))
        {
            \unlink($banner_patch.$banner->image);
        }
        else if (!empty($_url_amazon.'banners/images/'.$banner->image))
        {
            Storage::disk('s3')->delete('banners/images/'.$banner->image);
        }

      }

       $delete = Banner::where('id',$data_id)->delete();

       if(!$delete)
       {
           return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
       }

       return redirect($this->module->permalink)->with('msg_success', 'Banners '.$banner->title.' has been deleted');
       
    }




}
