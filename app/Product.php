<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Auth;

class Product extends Model
{
    public function attributes()
    {
        return $this->hasMany('App\ProductsAttribute','product_id');
    }

    public static function cartCount() {
        if(Auth::check()) {
            // echo "User is logged in; We will use Auth";
            $user_email = Auth::user()->email;
            $cartCount = DB::table('cart')->where('user_email',$user_email)->sum('quantity');
        } else {
            // echo "User is not logged in. We will use Session";
            $session_id = Session::get('session_id');
            $cartCount = DB::table('cart')->where('session_id',$session_id)->sum('quantity');
        }
        return $cartCount;
    }


    public static function productCount($cat_id) {
          $catCount = product::where(['category_id' => $cat_id, 'status' => 1 ])->count();
        //   dd($catCount);
          return $catCount;
    }


    public static function getCurrencyRates ($price) {

        $getCurrencies = DB::table('currencies')->where('status',1)->get();

        foreach($getCurrencies as $currency) {

            if($currency->currency_code == "IDR") {+
                $IDR_rate = \round($price/$currency->exchange_rate,2);
            } else if ($currency->currency_code == "USD") {
                $USD_rate = \round($price/$currency->exchange_rate,2);
            } else if ($currency->currency_code == "KHR") {
                $KHR_rate = \round($price/$currency->exchange_rate,2);
            } else if ($currency->currency_code == "EUR") {
                $EUR_rate = \round($price/$currency->exchange_rate,2);
            }

        }

        $currencyArr = array("IDR_rate" => $IDR_rate, "USD_rate" => $USD_rate, "KHR_rate" => $KHR_rate, "EUR_rate" => $EUR_rate);
        return $currencyArr;
    }


    public static function currencyRate ($price) {
        $currencyGet = DB::table('currencies')->where('status',1)->get();

        foreach($currencyGet as $curr) {
            if(!empty(Session::get('currencyLocale'))) {

            if((Session::get('currencyLocale')->currency_code == "IDR")) {
                if($curr->currency_code == "IDR") {
                    $rate_currency = round($price/$curr->exchange_rate,2);
                }
            } else if (Session::get('currencyLocale')->currency_code == "USD") {
                if($curr->currency_code == "USD") {
                    $rate_currency = round($price/$curr->exchange_rate,2);
                }
            } else if (Session::get('currencyLocale')->currency_code == "KHR") {
                if($curr->currency_code == "KHR") {
                    $rate_currency = round($price/$curr->exchange_rate,2);
                }
            }

        } else {
            if($curr->currency_code == "USD") {
                $currencyUSD = DB::table('currencies')->where('currency_code','USD')->first();
                Session::put('currencyLocale',$currencyUSD);
                $rate_currency = round($price/$curr->exchange_rate,2);
            }
        }
    }
        // dd(Session::get('currencyLocale'), $rate_currency);
        return $rate_currency;
    }


}
