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
            Image::make($files)->resize(227, 329)->save($billboard_patch);
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


    public function editBillboard($id = null) {
        
        $billboard = DB::table('billboards')->where('id',$id)->first();
        return view('admin.billboards.edit_billboard')->with(\compact('billboard'));
    }


}
