<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use DB;
use Date;

class CurrencyController extends Controller
{
    public function addCurrency (Request $request) { 

        if($request->isMethod('post')) {
            $data = $request->all();

            $exchange_rate =  str_replace([","],"",$data['exchange_rate']);
            $currency = new Currency;
            $currency->currency_name = $data['currency_name'] ?? "";
            $currency->currency_simbol = $data['currency_simbol'] ?? "";
            $currency->currency_code = $data['currency_code'] ?? "";
            $currency->exchange_rate = $exchange_rate ?? "";
            $currency->status = $data['status'] ?? "0";
            $currency->save();

            return \redirect()->back()->with('flash_message_success','Currency has been added successfully');
        }
        return view('admin.currencies.add_currency');
    }


    public function viewCurrency() {

        $currencies = DB::table('currencies')->orderBy('created_at','desc')->get();

        return \view('admin.currencies.view_currencies')->with(\compact('currencies'));
    }


    public function editCurrency(Request $request, $id = null ) {

        $currencyDetail = DB::table('currencies')->where('id',$id)->first();
        if($request->isMethod('post')) {
            $data = $request->all();
            $exchange_rate =  str_replace([","],"",$data['exchange_rate']);

            DB::table('currencies')->where('id',$id)->update([
                'currency_name' => $data['currency_name'] ?? "",
                'currency_simbol'  => $data['currency_simbol'] ?? "",
                'currency_code' => $data['currency_code'] ?? "",
                'exchange_rate' => $exchange_rate ?? "",
                'status' => $data['status'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return \redirect()->back()->with('flash_message_success','Currency has been updated successfully');
        }
        return \view('admin.currencies.edit_currency')->with(\compact('currencyDetail'));
    }


    public function deleteCurrency($id = null) {
          
        DB::table('currencies')->where('id',$id)->delete();
        return \redirect()->back()->with('flash_message_success','Currency has been deleted successfully');
    }




}
