<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;
use Date;
use Session;
use Image;
use App\Category;
use App\Product;
use App\ProductsAttribute; 
use App\ProductsImage;
use DB;
use App\Coupon;
use App\Banner;
use App\User;
use App\Country;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;

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
         if(!empty($data['care'])) 
         {
             $product->care = $data['care'];
         }else{
             $product->care = '';
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
         if(empty($data['status']))
         {
             $status = 0;
         }else{
             $status = 1;
         }
         $product->status = $status;
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
                'care' => $data['care'] ?? $data['c'] = "",
                'description' => $data['description'],
                'image' => $filename ?? $data['current-image'],
                'status' => $data['status'] ?? 0,
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
        $products = Product::orderBy('id','DESC')->get();
        $products = \json_decode(\json_encode($products));
        // dd($products);
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
                //    SKU Check 
                $attrCountSKU = ProductsAttribute::where('sku',$val)->count();
                if($attrCountSKU > 0 )
                {
                    return redirect('/admin/add-attribute/'.$id)->with('flash_message_error','SKU Already Exists, Please Add Another SKU. !');
                }
                // Size Check
                $attrCountSize = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                if($attrCountSize > 0)
                {
                    return redirect('/admin/add-attribute/'.$id)->with('flash_message_error','"'.$data['size'][$key].'" SIZE Already Exists For This Product, Please Add Another SIZE. !');
                }

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


    public function editAtributes(Request $request, $id = null)
    {

      if($request->isMethod('post'))
      {
         $data = $request->all();
         foreach($data['idAttr'] as $key => $attr )
         {
             ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->update([
                 'price' => $data['price'][$key],
                 'stock' => $data['stock'][$key]
             ]);
         }
         return redirect()->back()->with('flash_message_success','Product Attribute Has Been Update Successfully');
      }

    }


    public function deleteAttribute($id=null)
    {

        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success','Attribute has been deleted successfully !');

    }


    public function addImages(Request $request, $id=null)
    {
        $productDetails = Product::with('attributes')->where(['id' => $id])->first();
        // $productDetails = \json_decode(\json_encode($productDetails));
        if($request->isMethod('post'))
        {
           // add images
           $data = $request->all();

          if($request->hasFile('image'))
          {
             $files = $request->file('image');
            //  dd($request->file('image'));
              foreach($files as $file)
              {
                    // upload image after resize 
                  $pimage = new ProductsImage;
                  $extension = $file->getClientOriginalExtension();
                  $filename = rand(111,99999).'.'.$extension;
                  $large_image_patch = 'images/backend_images/products/large/'.$filename;
                  $medium_image_patch = 'images/backend_images/products/medium/'.$filename;
                  $small_image_patch = 'images/backend_images/products/small/'.$filename;
                  Image::make($file)->save($large_image_patch);
                  Image::make($file)->resize(600,600)->save($medium_image_patch);
                  Image::make($file)->resize(300,300)->save($small_image_patch);
                // storage image name in product table
                  $pimage->image = $filename;
                  $pimage->product_id = $data['product_id'];
                  $pimage->save();
              }
          }
          return redirect('/admin/add-images/'.$id)->with('flash_message_success','Product Image Has Ben Added Successfully');
        }
        $productsImages = ProductsImage::where(['product_id' => $id])->get();
        // dd($productDetails);
        return view('admin.products.add_images')->with(\compact('productDetails','productsImages'));

    }


    public function deleteAltImage($id=null)
    {
        // get product image nama
        $productImage = ProductsImage::where(['id' => $id])->first();
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
        ProductsImage::where(['id' => $id])->delete();

        return \redirect()->back()->with('flash_message_success','Product Image has been deleted successfully !');
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
            $productAll = Product::whereIn('category_id', $cat_ids)->where('status',1)->get();
            $productAll = \json_decode(\json_encode($productAll));

        }else{
            // If url is sub category url
            $productAll = Product::where(['category_id' => $categoryDetails->id])->where('status',1)->get();
           
        }
        $banners = Banner::where('status', 1)->get(); 
        // dd($banners);
        return view('products.listing')->with(\compact('categoryDetails','productAll','categories','banners'));
    }

    public function product($id = null)
    {
        //show 404 page if product disable
        $productsCount = Product::where(['id'=>$id, 'status'=>1])->count();
        if($productsCount == 0)
        {
            \abort(404); 
        }
        // get product detail
        $productDetails = Product::with('attributes')->where('id',$id)->first();
        
        $relatedProduct = Product::where('id', '!=' , $id )->where(['category_id'=>$productDetails->category_id])->get();
         foreach($relatedProduct->chunk(3) as $chunk)
         {
           foreach($chunk as $item)
            {
               
            }
         }
        // get all categories and subcategories
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        //Get Products Alternate Images
        $productAltImage = ProductsImage::where('product_id',$id)->get();
        // get Attribute stock
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');

        return \view('products.detail')->with(\compact('productDetails','categories','productAltImage','total_stock','relatedProduct'));
    }


    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        
        $proArr = \explode("-",$data['idSize']);
        $proArr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        print_r($proArr->price);
        print_r("#");
        print_r($proArr->stock);
        
    }


    public function addtocart(Request $request)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
        // dd($data);
        $session_id = Session::get('session_id');
        if(!isset($session_id))
        { 
            $session_id = \str_random(40);
            Session::put('session_id',$session_id);
        }

        $sizeArr = \explode("-",$data['size']);
        if(empty($sizeArr[1]))
        {
            return redirect()->back()->with('flash_message_error','Please select size !');
        }

        $countProducts = DB::table('cart')->where([
            'product_id' => $data['product_id'],
            'product_color' => $data['product_color'],
            'size' => $sizeArr[1],
            'session_id' => $session_id
          ])->count();

        if($countProducts > 0)
        {
            return redirect()->back()->with('flash_message_error','Product already exists in Cart !');
        }else{

            $getSKU = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'], 'size'=>$sizeArr[1] ])->first();

            DB::table('cart')->insert([
                'product_id' => $data['product_id'],
                'product_name' => $data['product_name'],
                'product_code' => $getSKU->sku,
                'product_color' => $data['product_color'],
                'size' => $sizeArr[1],
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'user_email' => Auth::user()->email ?? "",
                'session_id' => $session_id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }       
        
        return redirect('/cart')->with('flash_message_success','Product has been added in Cart !');
    }


    public function cart()
    {
        if(Auth::check())
        {
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where('user_email',$user_email)->get();
        }else{
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where('session_id',$session_id)->get();
        }

        foreach($userCart as $key => $product)
        {
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = "$productDetails->image";
           
        }
 
        return view('products.cart')->with(\compact('userCart'));
    }


    public function deleteCartProduct($id = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        
        DB::table('cart')->where('id',$id)->delete();
        return redirect('/cart')->with('flash_message_success','Product has been deleted from cart');
    }


    public function updateCartQuantity($id = null, $quantity = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        if($quantity == 0 )
        {
            $down = "1";
            DB::table('cart')->where('id',$id)->decrement('quantity',$down);
            return redirect('/cart')->with('flash_message_drop','Product Quantity has been drop successfully !');
        }else
        {
            $getCartDetails = DB::table('cart')->where('id',$id)->first();
            $getAttributeStock = ProductsAttribute::where('sku',$getCartDetails->product_code)->first();
            $updated_quantity = $getCartDetails->quantity+$quantity;
         
            if($getAttributeStock->stock >= $updated_quantity)
            {
                DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
                return redirect('/cart')->with('flash_message_success','Product Quantity has been update successfully !');

            }else{
                return redirect('/cart')->with('flash_message_error','Required Product Quantity is not available !');      
            }

           
        }

    
    }


    public function applyCoupon(Request $request, $id = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

         $data = $request->all();
         $couponCount = Coupon::where(['coupon_code' => $data['coupon_code']])->count();
        //  if coupon exist
         if($couponCount == "0")
         {
             return redirect()->back()->with('flash_message_error','This coupon do not exists');
         }else{
             $couponDetails = Coupon::where('coupon_code',$data['coupon_code'])->first();
            //  if coupon active
             if($couponDetails->status == "0")
             {
                 return redirect()->back()->with('flash_message_error','This coupon is not active !');
             }
             
             $expiry_date = $couponDetails->expiry_date;
             $current_date = Date('Y-m-d');
            //  if coupon expiry
             if($expiry_date < $current_date)
             {
                return redirect()->back()->with('flash_message_error','This coupon is expired !');
             }
            //  coupon is valid for discount // get cart total amount
            $session_id = Session::get('session_id');

            if(Auth::check())
            {
                $user_email = Auth::user()->email;
                $userCart = DB::table('cart')->where('user_email',$user_email)->get();
            }else{
                $userCart = DB::table('cart')->where('session_id',$session_id)->get();
            }

            $total_amount = 0;
            foreach($userCart as $item)
            {
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }
            if($couponDetails->amount_type == "Fixed")
            {
                $couponAmount = $couponDetails->amount;
            }else{
                $couponAmount = $total_amount * ($couponDetails->amount/100);
            }
            //  add coupon code & amount in session
            Session::put('CouponAmount',$couponAmount);
            Session::put('CouponCode',$data['coupon_code']);

            return redirect()->back()->with('flash_message_success','Coupon code successfully applied. You are availing discount !');

         }
    }


    public function checkout(Request $request)
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();
        
        // check if shipping exist
        $shippingCount = DeliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = Array();
        if($shippingCount > 0)
        {
            $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        }
        // update cart table with user email
        $session_id = Session::get('session_id');

        DB::table('cart')->where(['session_id' => $session_id])->update(['user_email' => $user_email]);

        if($request->isMethod('post'))
        {
            $data = $request->all();

            if(empty($data['billing_name']) || 
               empty($data['billing_address']) || 
               empty($data['billing_city']) || 
               empty($data['billing_state']) || 
               empty($data['billing_country']) || 
               empty($data['billing_pincode']) || 
               empty($data['billing_mobile']) || 
               empty($data['shipping_name']) ||
               empty($data['shipping_address']) ||
               empty($data['shipping_city']) ||
               empty($data['shipping_state']) ||
               empty($data['shipping_country']) ||
               empty($data['shipping_pincode']) || 
               empty($data['shipping_mobile']))
               {
                return redirect()->back()->with('flash_message_error','Please fill all field to checkout !');
               }
            //    user update
            User::where('id',$user_id)->update([
               'name' => $data['billing_name'],
               'address' => $data['billing_address'],
               'city' => $data['billing_city'],
               'state' => $data['billing_state'],
               'country' => $data['billing_country'],
               'pincode' => $data['billing_pincode'],
               'mobile' => $data['billing_mobile']]);
            if($shippingCount > 0)
            {
                // update shipping address
                DeliveryAddress::where('user_id',$user_id)->update([
                    'name' => $data['shipping_name'],
                    'address' => $data['shipping_address'],
                    'city' => $data['shipping_city'],
                    'state' => $data['shipping_state'],
                    'country' => $data['shipping_country'],
                    'pincode' => $data['shipping_pincode'],
                    'mobile' => $data['shipping_mobile']]);
            }else{
                // Add new shipping address
                $shipping = New DeliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['shipping_name'];
                $shipping->address = $data['shipping_address'];
                $shipping->city = $data['shipping_city'];
                $shipping->state = $data['shipping_state'];
                $shipping->country = $data['shipping_country'];
                $shipping->pincode = $data['shipping_pincode'];
                $shipping->mobile = $data['shipping_mobile'];
                $shipping->save();
            }
            return redirect()->action('ProductsController@orderReview');
            
        }

        return view('products.checkout')->with(\compact('userDetails','countries','shippingCount','shippingDetails'));

    }


    public function orderReview()
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        $userDetails = User::where('id',$user_id)->first();

        $userCart = DB::table('cart')->where('user_email',$user_email)->get();
        foreach($userCart as $key => $product)
        {
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = "$productDetails->image";
           
        }

        return view('products.order_review')->with(\compact('shippingDetails','userDetails','userCart'));
    }
    
    
    public function PlaceOrder(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();

            if(empty($data['payment_method'])) {
                return back()->with('flash_message_error','Please select method payment');
            }
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            // get shippong address off user
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();
            
            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = Session::get('CouponCode') ?? "";
            $order->coupon_amount = Session::get('CouponAmount') ?? "";
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grant_total = $data['grant_total'];
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();
        
            $cartProducts = DB::table('cart')->where(['user_email' => $user_email])->get();

            foreach($cartProducts as $pro)
            {
               $cartPro = new OrdersProduct;
               $cartPro->order_id = $order_id;
               $cartPro->user_id = $user_id;
               $cartPro->product_id = $pro->product_id;
               $cartPro->product_code = $pro->product_code;
               $cartPro->product_name = $pro->product_name;
               $cartPro->product_size = $pro->size;
               $cartPro->product_color = $pro->product_color;
               $cartPro->product_price = $pro->price;
               $cartPro->product_qty = $pro->quantity;
               $cartPro->save();
            }

            Session::put('order_id',$order_id);
            Session::put('grant_total',$data['grant_total']);

            if($data['payment_method'] == "COD")
            {
                return redirect('/thanks');
            }else{
                return redirect('/paypal');
            }
            
        }
    }


    public function thanks(Request $request)
    {
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();

        return view('orders.thanks');
    }

    
    public function thanksPaypal() 
    {
        return view('orders.thanks_paypal');
    }


    public function cancelPaypal() 
    {
        return view('orders.cancel_paypal');
    }


    public function paypal(Request $request)
    {
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        
        return view('orders.paypal');
    }
    

    public function userOrders()
    {
        $user_id = Auth::user()->id;
        $orders = Order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();
    //  dd(date_parse($orders->created_at)->format('l, j F Y - H:i A'));
        return view('orders.users_orders')->with(\compact('orders'));
    }


    public function userOrderDetails($order_id)
    {
        $user_id = Auth::user()->id;
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();

        return \view('orders.users_order_details')->with(\compact('orderDetails'));
    }

     
    public function viewOrders() 
    {
        $orders = Order::with('orders')->orderBy('id','desc')->get();
        return view('admin.orders.view_orders')->with(\compact('orders'));
    }


    public function viewOrderDetails($order_id)
    {
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(\json_encode($orderDetails));
        
        return view('admin.orders.order_details')->with(\compact('orderDetails'));
    }


}
