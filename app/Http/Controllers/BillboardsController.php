<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Date;
use DB;

class BillboardsController extends Controller
{

    public function addBillboard (Request $request) {

        if($request->isMethod('post'))
        {
            $data = $request->all();

          if($request->hasFile('image'))
          {
            $files = $request->file('image');
            // upload image after resize 
            $extension = $files->getClientOriginalExtension();
            $filename = rand(111,99999).'.'.$extension;
            $billboard_patch = 'images/backend_images/banners/'.$filename;
            Image::make($files)->resize(260, 377)->save($billboard_patch);
          }
          
          DB::table('billboards')->insert([
              'image' => $filename,
              'title' => $data['title'],
              'link' => $data['link'],
              'status' => $data['status'] ?? 0,
              'created_at' => date('Y-m-d H:i:s')
          ]);

          return redirect('/admin/add-billboard')->with('flash_message_success','Billboard Image Has Ben Added Successfully');
        }
        return view('admin.billboards.add_billboard');
    }


    public function viewBillboard() {
        $billboard = DB::table('billboards')->orderBy('created_at','DESC')->get();
        return view('admin.billboards.view_billboard')->with(\compact('billboard'));
    }


    public function editBillboard(Request $request, $id = null) {
        
        if($request->isMethod('post')) {
            $data = $request->all();
            
            if($request->hasFile('image'))
            {
              $files = $request->file('image');
              // upload image after resize 
              $extension = $files->getClientOriginalExtension();
              $filename = rand(111,99999).'.'.$extension;
              $billboard_patch = 'images/backend_images/banners/'.$filename;
              Image::make($files)->resize(260, 377)->save($billboard_patch);
            }

            if(!empty($filename)) {
                $image = $filename;
            } else {
                $image = $request['current_image'];
            }

            DB::table('billboards')->where('id',$id)->update([
                'image' => $image,
                'title' => $request['title'] ?: 0,
                'link' => $request['link'] ?: 0,
                'status' => $request['status'] ?: 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('flash_message_success','Billboard Image Has Ben Updated Successfully !');

        }

        $billboard = DB::table('billboards')->where('id',$id)->first();
        return view('admin.billboards.edit_billboard')->with(\compact('billboard'));
    }


    public function deleteBillboard($id = null) {

        $billboard = DB::table('billboards')->where('id',$id)->first();
        $billboard_patch = 'images/backend_images/banners/';
        // Delete large image if not exist folder
        if(\file_exists($billboard_patch.$billboard->image))
        {
            \unlink($billboard_patch.$billboard->image);
        }
        
        DB::table('billboards')->where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Billboard ImageImage Has Ben Deleted !');
    }


}
