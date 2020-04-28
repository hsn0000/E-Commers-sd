<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Auth;
use App\ProductsAttribute; 

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

    
    public static function userWislishCount() {
        if(Auth::check()) {
            $user_email = Auth::user()->email;
            $userWislishCount = DB::table('wish_list')->where('user_email',$user_email)->count();
        } else {
            $userWislishCount = array();
        }
        return $userWislishCount;
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
            if($curr->currency_code == "IDR") {
                $currencyIRD = DB::table('currencies')->where('currency_code','IDR')->first();
                Session::put('currencyLocale',$currencyIRD);
                $rate_currency = round($price/$curr->exchange_rate,2);
            }
        }
    }
        // dd(Session::get('currencyLocale'), $rate_currency);
        return $rate_currency;
    }
    

    public static function getProductStock($product_id, $product_size) {
        $getProduckStock = ProductsAttribute::select('stock')->where(['product_id' => $product_id, 'size' => $product_size])->first();
        return $getProduckStock->stock;
    }

    public static function getProductPrice($product_id, $product_size) {
        $getProductPrice = ProductsAttribute::select('price')->where(['product_id' => $product_id, 'size' => $product_size])->first();
        return $getProductPrice->price;
    }

    public static function deleteCartProduct($product_id, $user_email) {
        DB::table('cart')->where(['product_id' => $product_id, 'user_email' => $user_email])->delete();
    }


    public static function getProductStatus($product_id) {
        $getProductStatus = Product::select('status')->where('id', $product_id)->first();
        return $getProductStatus->status;
    }


    public static function getCategoryStatus($category_id) {
        $getCategoryStatus = Category::select('status')->where('id',$category_id)->first();
        return $getCategoryStatus->status;
    }


    public static function getAttributeCount($product_id, $product_size) {
        $getAttributeCount = ProductsAttribute::where(['product_id' => $product_id, 'size' => $product_size])->count();
        return $getAttributeCount;
    }

    public static function getShippingCharges($total_weight, $country) {
        $shippingDetails = DB::table('shipping_charges')->where('country',$country)->first();
        if($total_weight > 0) {
             if($total_weight > 0 && $total_weight <= 500) {
                 $shipping_charges = $shippingDetails->shipping_charges0_500g;
             } else if($total_weight >= 501 && $total_weight <= 1000) {
                $shipping_charges = $shippingDetails->shipping_charges501_1000g;
             }  else if($total_weight >= 1001 && $total_weight <= 2000) {
                $shipping_charges = $shippingDetails->shipping_charges1001_2000g;
             } else if($total_weight >= 2001 && $total_weight <= 5000) {
                $shipping_charges = $shippingDetails->shipping_charges2001_5000g;
             } else {
                $shipping_charges = 0;
             }
        } else {
           $shipping_charges = 0;
        }
        return $shipping_charges;
    }

    public static function getGrandTotal() {
        $getGrandTotal = "";
        $username = Auth::user()->email;
        $userCart = DB::table('cart')->where('user_email', $username)->get();
        $userCart = json_decode(json_encode($userCart), true);
        foreach($userCart as $product) {
            $productPrice = ProductsAttribute::where(['product_id' => $product['product_id'], 'size' => $product['size']])->first();
            $priceArray[] = $productPrice->price;
        }
        $grandTotal = array_sum($priceArray) + Session::get('ShippingCharges') - Session::get('CouponAmount');
        return $grandTotal;
    }


    public static function categoriesTotal() {
        $categoriesAll = DB::table('categories')->where('status',1)->count();
        return $categoriesAll;
    } 


    public static function productTotal() {
        $productTotalAll = DB::table('products')->where(['status' => 1, 'feature_item' => 1])->count();
        return $productTotalAll;
    } 



    public static function orderTotal() {
        $orderAll = DB::table('orders')->count();
        return $orderAll;
    } 


    public static function usersTotal() {
        $usersAll = DB::table('users')->where('status',1)->count();
        return $usersAll;
    } 


}
