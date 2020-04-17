<?php

namespace App\Exports;

use App\NewsletterSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class subscribersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $subscribersData = DB::table('newsletter_subscribers')->select('id', 'email', 'created_at')->where('status',1)->orderBy('id','Desc')->get();
        return $subscribersData;
    }
}
