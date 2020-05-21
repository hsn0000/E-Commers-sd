<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EnquiriesUsersController extends Controller
{
    //

    public function enquiriesList() {
        $enquiriesList = DB::table('enquiries')->orderBy('created_at','desc')->get();
        return view('admin.enquiries.enquiries_list',['enquiriesList' => $enquiriesList]);
    }

    public function enquiriesOutbox() {
        \abort(404);
    }

    public function deleteEnquiriesUsers($id = null) {
        DB::table('enquiries')->where('id', $id)->delete();
        return \redirect()->back()->with('flash_message_success','Enquiries has ben deleted !');
    }

}
