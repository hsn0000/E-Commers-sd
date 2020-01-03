<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Category;
use App\Banner;

class IndexController extends Controller
{
    public function index()
    {
        // in ascending order (By Default)
        $productAll = Product::get();
        // in descending order
        $productAll = Product::orderBy('id','DESC')->get();
        // in random order
        $productAll = Product::inRandomOrder()->where('status',1)->get(); 
        // get all category and sub category
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        // $categories = \json_decode(json_encode($categories));
        $banners = Banner::where('status', 1)->get();

        return view('index')->with(\compact('productAll','categories','banners'));

    }
}
