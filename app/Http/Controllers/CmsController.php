<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CmsPage;
use App\Category;
use DB;
use Illuminate\Support\Facades\Mail;
use Validator;

class CmsController extends Controller
{

    public function addCmsPage(Request $request) {

        if($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            $request->validate([
                'title' => 'required',
                'url' => 'required',
            ]);

            $cmspage = New CmsPage;
            $cmspage->title = $data['title'];
            $cmspage->description = $data['description'] ?: "";
            $cmspage->url = $data['url'];
            $cmspage->status = $data['status'] ?: 0;
            $cmspage->save();

            return redirect()->back()->with('flash_message_success','CMS Page has been added successfully !');
        }
        return view('admin.pages.add_cms_page');
    }


    public function editCmsPage(Request $request, $id = null) {

        $cmsPage = DB::table('cms_pages')->where('id',$id)->first();
        if($request->isMethod('post')) {
            $data = $request->all();

            $request->validate([
                'title' => 'required',
                'url' => 'required',
            ]);

            DB::table('cms_pages')->where('id',$id)->update([
                'title' => $data['title'],
                'url' => $data['url'],
                'description' => $data['description'],
                'status' => $data['status'] ?? 0
            ]);
            
            return redirect()->back()->with('flash_message_success','CMS Page has been updated successfully !');

        }
        return view('admin.pages.edit_cms_page')->with(\compact('cmsPage'));
    }


    public function viewCmsPage() {
        
        $cmsPages = DB::table('cms_pages')->orderBy('created_at','DESC')->get();

        return view('admin.pages.view_cms_page')->with(\compact('cmsPages'));
    }


    public function deleteCmsPage($id=null) {

        DB::table('cms_pages')->where('id',$id)->delete();
        return redirect('/admin/view-cms-page')->with('flash_message_success','CMS Page has been deleted successfully !');
    }


    public function cmsPage($url) {
         
        // redirec to page 404 if CMS page is disable or does not exist
        $cmsPageCount = DB::table('cms_pages')->where(['url' => $url, 'status' => 1] )->count();
        if($cmsPageCount > 0) {
            $cmsPageDetails = DB::table('cms_pages')->where('url',$url)->first();
            // $billboard = DB::table('billboards')->inRandomOrder()->orderBy('id','DESC')->where('status',1)->offset(0)->limit(1)->get();
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();
            return view('pages.cms_page')->with(\compact('cmsPageDetails','categories'));
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
            $email = "admin.ecomerce@yopmail.com";
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['message']
            ];
           Mail::send('emails.enquiry', $messageData, function ($message) use ($email) {
               $message->to($email)->subject('Enquiry from E-com Website');
           });

           return redirect()->back()->with('flash_message_success','Thanks for your enquiry. We will get back to you soon. ');
        }
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();
            // meta tags
            $meta_title = "Contact Us - E-commerce Website";
            $meta_description = "Contact us for any queries related to our products.";
            $meta_keyword = "contact us, queries";

        return view('pages.contact')->with(\compact('categories','meta_title','meta_description','meta_keyword'));
    }




}
