<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;
use Session;
use Image;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function addProduct(Request $request) 
    {

        if($request->isMethod('post')) 
        {
            $data = $request->all();
            // dd($data);
            if(empty($data['category_id']))
            {
                return \redirect()->back()->with('flash_message_error','Under Category Is Missing!'); 
            }
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
         if(!empty($data['description'])) 
         {
             $product->description = $data['description'];
         }else{
             $product->description = '';
         }
         $product->price = $data['price'];
         //upload image
         if($request->hasFile('image'))
         {
             $image_tmp = $data['image'];
         
             if($image_tmp->isValid()) 
             {
                $extension = $image_tmp->getClientOriginalExtension();
                $filename = rand(111,99999).'.'.$extension;
                $large_image_path = 'images/backend_images/products/large/'.$filename;
                $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                $small_image_path = 'images/backend_images/products/small/'.$filename;
                // resize image
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(300,300)->save($medium_image_path);
                Image::make($image_tmp)->resize(100,100)->save($small_image_path);
                // storage image name in product table
                $product->image = $filename;
             }
            
         }
         $product->save();
        //  return \redirect()->back()->with('flash_message_success','Product has been added successfully'); 

        return \redirect('/admin/view-product')->with('flash_message_success','Product has been added successfully'); 

        }
      // Categories dropdown star 
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>"; 
        foreach($categories as $cat) 
        {
            $categories_dropdown .= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat) 
            {
                $categories_dropdown .= "<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
     // Categories dropdown end
        return view('admin.products.add-product')->with(compact('categories_dropdown'));
    }

   
    public function editProduct(Request $request, $id=null)
    {   
        if($request->isMethod('post'))
        {
            $data = $request->all();
           //upload image
            if($request->hasFile('image'))
            {    
                $image_tmp = $data['image'];
            
                if($image_tmp->isValid()) 
                {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extension;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    // resize image
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($medium_image_path);
                    Image::make($image_tmp)->resize(100,100)->save($small_image_path);
                    // storage image name in product table
                }
                
            }
            // dd($filename);
            Product::where(['id' => $id])->update([
                'id' => $id,
                'category_id' => $data['category_id'],
                'product_name' => $data['product_name'],
                'product_code' => $data['product_code'],
                'product_color' => $data['product_color'],
                'description' => $data['description'],
                'image' => $filename ?? $data['current-image'],
                'price' => $data['price']
            ]);
            
            return \redirect()->back()->with('flash_message_success','Product has been updated successfully !');
        }
        // Get Product
        $productDetails = Product::where(['id' => $id])->first();
        // Categories dropdown star 
        $categories = Category::where(['parent_id' => 0])->get();
        $categories_dropdown = "<option selected disabled>Select</option>"; 
        foreach($categories as $cat) 
        {
            if($cat->id==$productDetails->category_id)
            {
                $selected = "selected";
            }else{
                $selected ="";
            }
            $categories_dropdown .= "<option value='".$cat->id."' ".$selected.">".$cat->name."</option>";
            $sub_categories = Category::where(['parent_id'=>$cat->id])->get();
            foreach($sub_categories as $sub_cat) 
            {
                if($sub_cat->id==$productDetails->category_id)
                {
                    $selected = "selected";
                }else{
                    $selected ="";
                }
                $categories_dropdown .= "<option value='".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
        // Categories dropdown end
        return view('admin.products.edit_product')->with(\compact('productDetails','categories_dropdown'));

    }


    public function deleteProductImage($id=null)
    {
        Product::where(['id' => $id])->update(['image'=>'']);
        return \redirect()->back()->with('flash_message_success','Product Image has been deleted successfully !');
    }


    public function viewProducts(Request $request)
    {
        $products = Product::get();
        $products = \json_decode(\json_encode($products));
        foreach($products as $key => $val)
        {
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
    //   dd($products);  
        return view('admin.products.view_products')->with(\compact('products'));
    }

}
