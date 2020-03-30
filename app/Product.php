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


}
