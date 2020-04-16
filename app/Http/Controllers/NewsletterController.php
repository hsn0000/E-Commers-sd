<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


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
}
  