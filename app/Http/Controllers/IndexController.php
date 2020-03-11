<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\Banner;
use DB;

class IndexController extends Controller
{
    public function index()
    {
        // // in ascending order (By Default)
        // $productAll = Product::get();
        // // in descending order
        // $productAll = Product::orderBy('id','DESC')->get();
        // in random order
        $productAll = Product::inRandomOrder()->orderBy('id','DESC')->where('status',1)->where('feature_item',1)->offset(0)->limit(12)->get(); 
        // get all category and sub category
        // dd($productAll);
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        // $categories = \json_decode(json_encode($categories));
        $banners = Banner::where('status', 1)->get();
        $billboard = DB::table('billboards')->orderBy('id','DESC')->where('status',1)->offset(0)->limit(4)->get();
// dd($billboard);
        return view('index')->with(\compact('productAll','categories','banners','billboard'));

    }
}
