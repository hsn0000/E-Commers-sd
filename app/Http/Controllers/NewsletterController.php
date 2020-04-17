<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Exports\subscribersExport;
use App\NewsletterSubscriber;
// use Maatwebsite\Excel\Facades\Excel;
use Excel;

class NewsletterController extends Controller
{
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


    public function viewNewsletterSubscribers() {
        $newsletters = DB::table('newsletter_subscribers')->get();
        return \view('admin.newsletters.view_newsletters')->with(compact('newsletters'));
    }


    public function updateNewsletterStatus($id, $status) {
        DB::table('newsletter_subscribers')->where('id',$id)->update([
            'status' => $status
        ]);
        return \redirect()->back()->with('flash_message_success','Newsletter status has ben updated !');
    }


    public function deleteNewsletterEmail($id) {
        DB::table('newsletter_subscribers')->where('id',$id)->delete();
        return \redirect()->back()->with('flash_message_success','Newsletter email has ben deleted !');
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


    public function exportNewsletterEmail() {
        return Excel::download(new subscribersExport, 'subscribers.xlsx');
    }



}
  