<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class usersExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usersData = DB::table('users AS u')
        ->leftJoin('users_biodata AS ub', 'u.id', '=', 'ub.user_id')
        ->select('name','email','address','city','state','country','pincode','mobile')->where('admin', 0)->get();
        return $usersData;
    }

    public function headings(): array {
        return ['name', 'email','address','city','state','country','pincode','mobile'];
    }

}
