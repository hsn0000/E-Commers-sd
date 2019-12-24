<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductsAttribute; 

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
                Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                Image::make($image_tmp)->resize(300,300)->save($small_image_path);
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
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);
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


    public function deleteProduct($id=null) 
    {
       // get product image nama
       $productImage = Product::where(['id' => $id])->first();
       // get product image patch
       $large_image_patch = 'images/backend_images/products/large/';
       $medium_image_patch = 'images/backend_images/products/medium/';
       $small_image_patch = 'images/backend_images/products/small/';
       // Delete large image if not exist folder
       if(\file_exists($large_image_patch.$productImage->image))
       {
           \unlink($large_image_patch.$productImage->image);
       }
        // Delete medium image if not exist folder
        if(\file_exists($medium_image_patch.$productImage->image))
        {
            \unlink($medium_image_patch.$productImage->image);
        }
         // Delete small image if not exist folder
       if(\file_exists($small_image_patch.$productImage->image))
       {
           \unlink($small_image_patch.$productImage->image);
       }
       // delete image from product table
       Product::where(['id' => $id])->delete();
       return \redirect()->back()->with('flash_message_success','Product Has Been Deleted Successfully');

    }


    public function deleteProductImage($id=null)
    {
        // get product image nama
        $productImage = Product::where(['id' => $id])->first();
        // get product image patch
        $large_image_patch = 'images/backend_images/products/large/';
        $medium_image_patch = 'images/backend_images/products/medium/';
        $small_image_patch = 'images/backend_images/products/small/';
        // Delete large image if not exist folder
        if(\file_exists($large_image_patch.$productImage->image))
        {
            \unlink($large_image_patch.$productImage->image);
        }
         // Delete medium image if not exist folder
         if(\file_exists($medium_image_patch.$productImage->image))
         {
             \unlink($medium_image_patch.$productImage->image);
         }
          // Delete small image if not exist folder
        if(\file_exists($small_image_patch.$productImage->image))
        {
            \unlink($small_image_patch.$productImage->image);
        }
        // delete image from product table
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


    public function addAtributes(Request $request, $id=null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        // $productDetails = \json_decode(\json_encode($productDetails));
        if($request->isMethod('post'))
        {
              $data = $request->all();
         
           foreach($data['sku'] as $key => $val)
           {

               if(!empty($val))
               {
                   $attribute = new ProductsAttribute;
                   $attribute->sku = $val;
                   $attribute->product_id = $id;
                   $attribute->size = $data['size'][$key];
                   $attribute->price = $data['price'][$key];
                   $attribute->stock = $data['stock'][$key];
                   $attribute->save();
               }
           }

           return redirect('/admin/add-attribute/'.$id)->with('flash_message_success','Product Attributes Has Been Added Successfully !');
        }
        // dd($productDetails);
        return view('admin.products.add_attributes')->with(\compact('productDetails'));

    }


    public function deleteAttribute($id=null)
    {

        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute has been deleted successfully !');

    }


    public function products($url=null)
    {
        // Show 404 page if category URL does not exist
        $countCategory = Category::where(['url' => $url,'status'=> 1])->count();
        // dd($countCategory);
        if($countCategory == 0)
        {
            abort(404);
        }
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['url' => $url])->first();
        
        if($categoryDetails->parent_id == 0)
        {
            // if url is main category url
            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            foreach($subCategories as $key => $subcat)
            { 
                $cat_ids[] = $subcat->id;
            }
            $productAll = Product::whereIn('category_id', $cat_ids)->get();
            $productAll = \json_decode(\json_encode($productAll));
            // dd($productAll);
        }else{
            // If url is sub category url
            $productAll = Product::where(['category_id' => $categoryDetails->id])->get();
        }
        // dd($productsAll);
        return view('products.listing')->with(\compact('categoryDetails','productAll','categories'));
    }

    public function product($id = null)
    {
        // get product detail
        $productDetails = Product::where(['id' => $id])->first();
        // get all categories and subcategories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        return \view('products.detail')->with(\compact('productDetails','categories'));
    }


}
