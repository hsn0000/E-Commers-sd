<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
{
    public function addCurrency (Request $request) { 

        if($request->isMethod('post')) {
            $data = $request->all();
            
            $currency = new Currency;
            $currency->currency_name = $data['currency_name'] ?? "";
            $currency->currency_simbol = $data['currency_simbol'] ?? "";
            $currency->currency_code = $data['currency_code'] ?? "";
            $currency->exchange_rate = $data['exchange_rate'] ?? "";
            $currency->status = $data['status'] ?? "0";
            $currency->save();

            return \redirect()->back()->with('flash_message_success','Currency has been added successfully');
        }
        return view('admin.currencies.add_currency');
    }
}
