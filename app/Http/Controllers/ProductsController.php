<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
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
use \Illuminate\Support\Facades\Storage;
use App\Exports\productsExport;
use Excel;
// reference the Dompdf namespace
use Dompdf\Dompdf;
use PDF;
use Carbon\Carbon;

class ProductsController extends Controller
{

    public function __construct() {
        // sas
    }

    public function addProduct(Request $request) 
    {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        if($request->isMethod('post')) 
        {
            $data = $request->all();
            $price = str_replace(["Rp",","],"",$data['price']);

            if(empty($data['category_id'])) 
            {
                return \redirect()->back()->with('flash_message_error','under_category_is_missing'); 
            }

            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->description = $data['description'] ?? "";
            $product->sleeve = $data['sleeve'] ?? "";
            $product->pattern = $data['pattern'] ?? "";
            $product->care = $data['care'] ?? "";
            $product->price = $price;
            $product->weight = $data['weight'] ?? "";
         /* upload image */
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

        /* upload vidio */  
        if($request->hasFile('video')) {
            $video_tmp = $data['video'];
            $video_name = $video_tmp->getClientOriginalName();
            $video_patch = 'videos/';
            $video_tmp->move($video_patch,$video_name);
            $product->video = $video_name;
        }

         $product->status = $data['status']  ?? 0;
         $product->feature_item = $data['feature_item'] ?? 0;
         $product->save();
         //  return \redirect()->back()->with('flash_message_success','Product has been added successfully'); 
        return \redirect('/admin/view-product')->with('flash_message_success','product_has_been_added_successfully'); 

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

             return view('admin.products.add-product')->with(compact('categories_dropdown'));
    }

   
    public function editProduct(Request $request, $id=null)
    {   
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $price = str_replace(["Rp",","],"",$data['price']);
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

            /* upload vidio */  
            if($request->hasFile('video')) {
                $video_tmp = $data['video'];
                $video_name = $video_tmp->getClientOriginalName();
                $video_patch = 'videos/';
                $video_tmp->move($video_patch,$video_name);
            }   

            if(isset($video_tmp)) {
                 /* Delete video if exists in folder */      
                 if(Storage::disk('public')->exists($video_patch.$data['current-video'])) {
                        unlink($video_patch.$data['current-video']);
                }
            }
    
            Product::where(['id' => $id])->update([
                'id' => $id,
                'category_id' => $data['category_id'],
                'product_name' => $data['product_name'],
                'product_code' => $data['product_code'],
                'product_color' => $data['product_color'],
                'sleeve' => $data['sleeve'] ?? "",
                'pattern' => $data['pattern'] ?? "",
                'care' => $data['care'] ?? $data['care'] = "",
                'description' => $data['description'],
                'image' => $filename ?? $data['current-image'],
                'video' => $video_name ?? $data['current-video'],
                'feature_item' => $data['feature_item'] ?? 0,
                'status' => $data['status'] ?? 0,
                'price' => $price,
                'weight' => $data['weight'] ?? "",
            ]);
            
            return \redirect()->back()->with('flash_message_success','product_has_been_updated_successfully');
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
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
       // get product image nama
       $productImgVideo = Product::where(['id' => $id])->first();
       // get product image patch
       $large_image_patch = 'images/backend_images/products/large/';
       $medium_image_patch = 'images/backend_images/products/medium/';
       $small_image_patch = 'images/backend_images/products/small/';
       // Delete large image if not exist folder
       if(\file_exists($large_image_patch.$productImgVideo->image))
       {
           \unlink($large_image_patch.$productImgVideo->image);
       } 
        // Delete medium image if not exist folder
        if(\file_exists($medium_image_patch.$productImgVideo->image))
        {
            \unlink($medium_image_patch.$productImgVideo->image);
        }
         // Delete small image if not exist folder
       if(\file_exists($small_image_patch.$productImgVideo->image))
       {
           \unlink($small_image_patch.$productImgVideo->image);
       }

       $video_patch = "videos/";
            /* Delete video if exists in folder */ 
        if(!empty($productImgVideo->video)) {
            if(file_exists($video_patch.$productImgVideo->video)) {
                unlink($video_patch.$productImgVideo->video);
            }
        }

       // delete image from product table
       Product::where(['id' => $id])->delete();
       return \redirect()->back()->with('flash_message_success','product_has_been_deleted_successfully');

    }


    public function deleteProductImage($id=null)
    {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
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

        return \redirect()->back()->with('flash_message_success','product_image_has_been_deleted_successfully');
    }


    public function deleteProductVideo($id = null) {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        $productVideo = DB::table('products')->select('video')->where('id',$id)->first();
        $video_patch = 'videos/';
       /* Delete video if exists in folder */   
        if(file_exists($video_patch.$productVideo->video)) {
             unlink($video_patch.$productVideo->video);
        }
        /* delete video from table product */
        DB::table('products')->where('id', $id)->update(['video' => '']);
        return redirect()->back()->with('flash_message_success','Product video has ben deleted successfully'); 
    }


    public function viewProducts(Request $request)
    {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        $products = Product::orderBy('id','DESC')->get();
        $products = \json_decode(\json_encode($products));
        foreach($products as $key => $val)
        {
            $category_name = Category::where(['id' => $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }
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
                    return redirect('/admin/add-attribute/'.$id)->with('flash_message_error','sku_already_exists');
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

           return redirect('/admin/add-attribute/'.$id)->with('flash_message_success','product_attributes_has_been_added');
        }
        // dd($productDetails);
        return view('admin.products.add_attributes')->with(\compact('productDetails'));

    }


    public function editAtributes(Request $request, $id = null)
    {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
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
         return redirect()->back()->with('flash_message_success','product_attribute_has_been_update');
      }

    }


    public function deleteAttribute($id=null)
    {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        ProductsAttribute::where(['id' => $id])->delete();
        return redirect()->back()->with('flash_message_success','attribute_has_been_deleted');
    }


    public function addImages(Request $request, $id=null)
    {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
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
          return redirect('/admin/add-images/'.$id)->with('flash_message_success','product_image_has_ben_added');
        }
        $productsImages = ProductsImage::where(['product_id' => $id])->get();
        // dd($productDetails);
        return view('admin.products.add_images')->with(\compact('productDetails','productsImages'));

    }

    
    public function deleteAltImage($id=null)
    {
        if(Session::get('adminDetails')['products_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
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

        return \redirect()->back()->with('flash_message_success','product_image_has_been_deleted');
    }
    

    public function products($url=null)
    {
        // Show 404 page if category URL does not exist
        $countCategory = Category::where(['url' => $url,'status'=> 1])->count();
        if($countCategory == 0)
        {
            abort(404);
        }
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoryDetails = Category::where(['url' => $url])->first();
                
        if($categoryDetails->parent_id == 0)
        {
            // if url is main category url
            $countSubCategories = Category::where(['parent_id' => $categoryDetails->id])->count();
            if($countSubCategories == 0 ) {
                  abort(400);
            } 
            $subCategories = Category::where(['parent_id' => $categoryDetails->id])->get();
            foreach($subCategories as $key => $subcat)
            { 
                $cat_ids[] = $subcat->id;
            }
            $productAll = DB::table('products')->whereIn('products.category_id', $cat_ids)->where('products.status',1)->orderBy('products.id','desc');
            // $productAll = \json_decode(\json_encode($productAll));
            $allProductCount = Product::whereIn('category_id', $cat_ids)->where('status',1)->count();
            $breadcrumb = "<a href='/' style='color: darkorange;'>Home</a> / <a href='".$categoryDetails->url."' style='color: darkorange;' >".$categoryDetails->name."</a>";
        }else{
            // If url is sub category url
            $productAll = DB::table('products')->where(['products.category_id' => $categoryDetails->id])->where('products.status',1)->orderBy('id','desc');
            $allProductCount = Product::where(['category_id' => $categoryDetails->id])->where('status',1)->count();    
            $mainCategory = DB::table('categories')->where('id',$categoryDetails->parent_id)->first();
            $breadcrumb = "<a href='/' style='color: darkorange;'>Home</a> / <a href='".$mainCategory->url."' style='color: darkorange;' >".$mainCategory->name."</a> / <a href='".$categoryDetails->url."' style='color: darkorange;' >".$categoryDetails->name."</a>";
        }

        if(!empty($_GET['color'])) {
            $colorArray = explode( '-',$_GET['color']);
            $productAll =  $productAll->whereIn('products.product_color',$colorArray);
        }

        if(!empty($_GET['sleeve'])) {
            $sleeveArray = explode( '-',$_GET['sleeve']);
            $productAll =  $productAll->whereIn('products.sleeve',$sleeveArray);
        }

        if(!empty($_GET['pattern'])) {
            $patternArray = explode( '-',$_GET['pattern']);
            $productAll =  $productAll->whereIn('products.pattern',$patternArray);
        }

        if(!empty($_GET['size'])) {
            $sizeArray = explode( '-',$_GET['size']);
            $productAll =  $productAll->join('products_attributes','products_attributes.product_id', '=', 'products.id')
            ->select('products.*','products_attributes.product_id','products_attributes.size')
            ->groupBy('products_attributes.product_id')
            ->whereIn('products_attributes.size',$sizeArray);
        }
        // dd($productAll,$sizeArray, $allProductCount);
        $productAll = $productAll->paginate(9);
        // $productAll = json_decode(json_encode($productAll));
        // dd($productAll);
        $colorArray = DB::table('products')->select('product_color')->groupBy('product_color')->get();
        $sleeveArray = DB::table('products')->select('sleeve')->where('sleeve', '!=', '')->groupBy('sleeve')->get();
        $patternArray = DB::table('products')->select('pattern')->where('pattern', '!=', '')->groupBy('pattern')->get();
        $sizeArray = ProductsAttribute::select('size')->where('size', '!=', '')->where('size', '!=', 'tes')->groupBy('size')->get();
        $sizeArray = array_flatten(json_decode(json_encode($sizeArray),true));

        $banners = Banner::where('status', 1)->get(); 
        $billboard = DB::table('billboards')->inRandomOrder()->orderBy('id','DESC')->where('status',1)->offset(0)->limit(1)->get();
        // meta tags
        $meta_title = $categoryDetails->meta_title;
        $meta_description = $categoryDetails->meta_description;
        $meta_keyword = $categoryDetails->meta_keywords;

        return view('products.listing')->with(\compact('categoryDetails','productAll','categories','banners','billboard','allProductCount','meta_title','meta_description','meta_keyword','sizeArray','breadcrumb'));
    }


    public function filter(Request $request) {

        $data = $request->all();
        $colorUrl = "";
        if(!empty($data['colorFilter'])) {
            foreach($data['colorFilter'] as $color) {
                if(empty($colorUrl)) {
                    $colorUrl = "&color=".$color;
                } else {
                    $colorUrl .= "-".$color;
                }       
            }   
        }

        $sleeveUrl = "";
        if(!empty($data['sleeveFilter'])) {
            foreach($data['sleeveFilter'] as $slv) {
                if(empty($sleeveUrl)) {
                    $sleeveUrl = "&sleeve=".$slv;
                } else {
                    $sleeveUrl .= "-".$slv;
                }       
            }
            
        }

        $patternUrl = "";
        if(!empty($data['patternFilter'])) {
            foreach($data['patternFilter'] as $ptr) {
                if(empty($patternUrl)) {
                    $patternUrl = "&pattern=".$ptr;
                } else {
                    $patternUrl .= "-".$ptr;
                }       
            }           
        }

        $sizeUrl = "";
        if(!empty($data['sizeFilter'])) {
            foreach($data['sizeFilter'] as $siz) {
                if(empty($sizeUrl)) {
                    $sizeUrl = "&size=".$siz;
                } else {
                    $sizeUrl .= "-".$siz;
                }       
            }           
        }
        // dd($data['url']);
        $finalUrl = "products/".$data['url']."?".$colorUrl.$sleeveUrl.$patternUrl.$sizeUrl;
        return Redirect::to($finalUrl);
    }


    public function searchProducts(Request $request)
    {
        if($request->isMethod('post')) {
            $data = $request->all();

            $banners = Banner::where('status', 1)->get();
            $billboard = DB::table('billboards')->orderBy('id','DESC')->where('status',1)->offset(0)->limit(1)->get();
            $categories = Category::with('categories')->where(['parent_id' => 0])->get();
            $search_product = $data['product'];
            // $productAll = Product::where('product_name','like','%'.$search_product.'%')->orwhere('product_code',$search_product)->where('status',1)->paginate(9);
            $productCount = DB::table('products')->where( function($query) use ($search_product) {
                $query->where('product_name','like','%'.$search_product.'%')
                ->orwhere('product_code',$search_product)
                ->orwhere('description','like','%'.$search_product.'%')
                ->orwhere('product_color','like','%'.$search_product.'%');
            })->where('status',1)->count();

            $productAll = DB::table('products')->where( function($query) use ($search_product) {
                $query->where('product_name','like','%'.$search_product.'%')
                ->orwhere('product_code',$search_product)
                ->orwhere('description','like','%'.$search_product.'%')
                ->orwhere('product_color','like','%'.$search_product.'%');
            })->where('status',1)->get();

            $sizeArray = ProductsAttribute::select('size')->where('size', '!=', '')->where('size', '!=', 'tes')->groupBy('size')->get();
            $sizeArray = array_flatten(json_decode(json_encode($sizeArray),true));
            $breadcrumb = "<a href='/' style='color: darkorange;'>Home</a> / ".$search_product;

            return view('products.listing')->with(\compact('search_product','productAll','categories','banners','billboard','productCount','sizeArray','breadcrumb'));
        }
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
        $categoryDetails = Category::where(['id' => $productDetails->category_id])->first();
                
        if($categoryDetails->parent_id == 0)
        {
            $breadcrumb = "<a href='/' style='color: darkorange;'>Home</a> / <a href='/products/".$categoryDetails->url."' style='color: darkorange;' >".$categoryDetails->name."</a> / ".$productDetails->product_name;
        }else{
            $mainCategory = DB::table('categories')->where('id',$categoryDetails->parent_id)->first();
            $breadcrumb = "<a href='/' style='color: darkorange;'>Home</a> / <a href='/products/".$mainCategory->url."' style='color: darkorange;' >".$mainCategory->name."</a> / <a href='/products/".$categoryDetails->url."' style='color: darkorange;' >".$categoryDetails->name."</a> / <span style='color: cornflowerblue;' > ".$productDetails->product_name." </span>";
        }

        //Get Products Alternate Images
        $productAltImage = ProductsImage::where('product_id',$id)->get();
        // get Attribute stock
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');
        $billboard = DB::table('billboards')->inRandomOrder()->orderBy('id','DESC')->where('status',1)->offset(0)->limit(2)->get();
        $meta_title = $productDetails->product_name;
        $meta_description = $productDetails->description;
        $meta_keyword = $productDetails->product_name;

        return \view('products.detail')->with(\compact('productDetails','categories','productAltImage','total_stock','relatedProduct','billboard','meta_title','meta_description','meta_keyword','breadcrumb'));
    }


    public function getProductPrice(Request $request)
    {
        $data = $request->all();
        
        $proArr = \explode("-",$data['idSize']);
        $proArr = ProductsAttribute::where(['product_id' => $proArr[0], 'size' => $proArr[1]])->first();
        $getCurrencyRates = Product::getCurrencyRates($proArr->price);
        $price = Product::currencyRate($proArr->price); 
        $price = is_number($price,2);
        echo ($price."-".$proArr->price."-".$getCurrencyRates['IDR_rate']."-".$getCurrencyRates['USD_rate']."-".$getCurrencyRates['KHR_rate']."-".$getCurrencyRates['EUR_rate']);
        // echo("#");
        // echo(array("t" => $getCurrencyRates['USD_rate']));
        echo("#");
        echo($proArr->stock);

    }


    public function addtocart(Request $request)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
        // dd($data);
        if(!empty($data['wishListButton']) && $data['wishListButton'] == "Wish List"  ) {
            // check user is login in
            if(!Auth::check()) {
                return redirect()->back()->with('flash_message_error','Please login to add product in your Wish List');
            }
            // check size is selected
            if(empty($data['size'])) {
                return redirect()->back()->with('flash_message_error', 'please select size to add product in your wish list');
            }
            // get product size
            $sizeArr = \explode("-",$data['size']);
            $product_sizes = $sizeArr[1];
            // get product price
            $proPrice = DB::table('products_attributes')->where(['product_id' => $data['product_id'], 'size' =>$product_sizes])->first();
            $product_price = $proPrice->price;
            // get user email
            $user_email = Auth::user()->email;
            // sert quantity as 1
            $quantity = 1;
            // get current date
            $created_at = Carbon::now();

            $wishListCount = DB::table('wish_list')->where(['user_email' => $user_email, 'product_id' => $data['product_id'], 'product_color' => $data['product_color'], 'product_code' => $data['product_code'], 'size' => $product_sizes])->count();
            if($wishListCount > 0) {
                return redirect()->back()->with('flash_message_error','Product already exists in Wish List !');
            } else {
                // insert product in wishlist
                DB::table("wish_list")->insert([
                    'product_id' => $data['product_id'],
                    'product_name' => $data['product_name'],
                    'product_code' => $data['product_code'],
                    'product_color' => $data['product_color'],
                    'price' => $product_price,
                    'size' => $product_sizes,
                    'quantity' => $quantity,
                    'user_email' => $user_email,
                    'created_at' => $created_at
                ]);
                return redirect()->back()->with('flash_message_success','Product hash been added in Wish List');
            }

        } else {
            // if product added from wish list
            if(!empty($data['cartButtom']) && $data['cartButtom'] == "Add to Cart" ){
                $data['quantity'] = 1;
            }
            // check product stock is available or not
            $product_size = explode("-",$data['size']);
            $getProductStock = ProductsAttribute::where(['product_id' => $data['product_id'],'size' => $product_size["1"]])->first();
            if($getProductStock->stock < $data['quantity']) {
                return \redirect()->back()->with('flash_message_error','Required Quantity is not available !');
        }

        $session_id = Session::get('session_id');
        if(!isset($session_id))
        { 
            $session_id = \str_random(40);
            Session::put('session_id',$session_id);
        }

        $sizeArr = \explode("-",$data['size']);
        $product_sizes = $sizeArr[1];

        if(empty(Auth::check())) {
            $countProducts = DB::table('cart')->where([
                'product_id' => $data['product_id'],
                'product_color' => $data['product_color'],
                'size' => $product_sizes,
                'session_id' => $session_id
              ])->count();
    
            if($countProducts > 0)
            {
                return redirect()->back()->with('flash_message_error','Product already exists in Cart !');
            }

        } else {
            $countProducts = DB::table('cart')->where([
                'product_id' => $data['product_id'],
                'product_color' => $data['product_color'],
                'size' => $product_sizes,
                'user_email' => Auth::User()->email,
              ])->count();
    
            if($countProducts > 0)
            {
                return redirect()->back()->with('flash_message_error','Product already exists in Cart !');
            }

        } 
        if(empty($product_sizes))
        {
            return redirect()->back()->with('flash_message_error','Please select size !');
        }
        // else{
            $getSKU = ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'], 'size'=>$product_sizes ])->first();

            DB::table('cart')->insert([
                'product_id' => $data['product_id'],
                'product_name' => $data['product_name'],
                'product_code' => $getSKU->sku,
                'product_color' => $data['product_color'],
                'size' => $product_sizes,
                'price' => $data['price'],
                'quantity' => $data['quantity'],
                'user_email' => Auth::user()->email ?? "",
                'session_id' => $session_id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        // }       
            return redirect('/cart')->with('flash_message_success','Product has been added in Cart !');
        }

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
 
        $meta_title ="Shopping Cart - E-commerce web";
        $meta_description = "View Shopping Cart Of E-commerce Web";
        $meta_keyword = "shopping cart, e-com Website";
        return view('products.cart')->with(\compact('userCart','meta_title','meta_description','meta_keyword'));
    }


    public function deleteCartProduct($id = null)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        
        DB::table('cart')->where('id',$id)->delete();
        return redirect('/cart')->with('flash_message_success','Product has been deleted from cart');
    }

    
    public function wishList() {
        if(Auth::check()) {
            $user_email = Auth::user()->email;
            $userWishList = DB::table('wish_list')->where('user_email',$user_email)->get();
            foreach($userWishList as $key => $product)
            {
                $productDetails = Product::where('id',$product->product_id)->first();
                $userWishList[$key]->image = "$productDetails->image";
            }
        }else {
            $userWishList = array();
        }

        $meta_title ="Wish List - E-commerce web";
        $meta_description = "View Wish List Of E-commerce Web";
        $meta_keyword = "wish list, e-com Website";
        return view('products.wish_list')->with(\compact('userWishList','meta_title','meta_description','meta_keyword'));
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
        } else {

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
                $pincodeCount = DB::table('pincodes')->where('pincode',$data['shipping_pincode'])->count();
                if($pincodeCount == 0 ) {
                    return \redirect()->back()->with('flash_message_error','Your location is not available for delivery. please choose another location');
                }
            return redirect()->action('ProductsController@orderReview');
            
        }
        
        $meta_title ="Checkout - E-com Website";
        return view('products.checkout')->with(\compact('userDetails','countries','shippingCount','shippingDetails','meta_title'));

    }


    public function orderReview()
    {
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $shippingDetails = DeliveryAddress::where('user_id',$user_id)->first();
        $userDetails = User::where('id',$user_id)->first();

        $userCart = DB::table('cart')->where('user_email',$user_email)->get();
        $total_weight = 0;
        foreach($userCart as $key => $product)
        {
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = "$productDetails->image";   
            $total_weight = $total_weight + $productDetails->weight;
        }
        $codPincodeCount = DB::table('cod_pincodes')->where('pincode',$shippingDetails->pincode)->count();
        $prepaidPincodeCount = DB::table('prepaid_pincodes')->where('pincode',$shippingDetails->pincode)->count();
        //  fetch shipping charges
        $shippingCharges = Product::getShippingCharges($total_weight, $shippingDetails->country);
        Session::put("ShippingCharges",$shippingCharges);

        $meta_title ="Order Review - E-com Website";
        return view('products.order_review')->with(\compact('shippingDetails','userDetails','userCart','meta_title','codPincodeCount','prepaidPincodeCount','shippingCharges'));
    }
    
    
    public function PlaceOrder(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();

            if(empty($data['payment_method'])) {
                $request->validate([
                    'payment_method' => 'required'
                ]);
                return back()->with('flash_message_error','Please select method payment');
            }
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            // Prevent out of stock produck from ordering
            $userCart = DB::table('cart')->where('user_email',$user_email)->get();
            foreach($userCart as $cart) {
                $getAttributeCount = Product::getAttributeCount($cart->product_id, $cart->size); 
                if($getAttributeCount == 0) {
                    Product::deleteCartProduct($cart->product_id, $user_email);
                    return redirect('/cart')->with('flash_message_error','One the product is not available. Try Again !');
                }

                $product_stock = Product::getProductStock($cart->product_id, $cart->size); 
                if($product_stock == 0) {
                    Product::deleteCartProduct($cart->product_id, $user_email);
                    return redirect('/cart')->with('flash_message_error','Sold Out Product remove from cart. Try Again !');
                }

               if($cart->quantity > $product_stock) {
                    return redirect('/cart')->with('flash_message_error','Reduce Product Stock and try again.');
               }

               $product_status = Product::getProductStatus($cart->product_id);
               if($product_status == 0) {
                  Product::deleteCartProduct($cart->product_id, $user_email);
                  return redirect('/cart')->with('flash_message_error','Disable Product remove from cart. Please try again. !');
               }

               $getCategoryId = DB::table('products')->select('category_id')->where('id',$cart->product_id)->first();
               $category_status = Product::getCategoryStatus($getCategoryId->category_id);
               if($category_status == 0) {
                    Product::deleteCartProduct($cart->product_id, $user_email);
                    return redirect('/cart')->with('flash_message_error','One of the product category is disabled. Please try again. !');
               }
            }

            // get shippong address off user
            $shippingDetails = DeliveryAddress::where(['user_email' => $user_email])->first();
            $pincodeCount = DB::table('pincodes')->where('pincode',$shippingDetails->pincode)->count();

            if($pincodeCount == 0 ) {
                return \redirect()->back()->with('flash_message_error','Your location is not available for delivery. please choose another location');
            }
           /*  //  fetch shipping charges
            $shippingCharges = Product::getShippingCharges($shippingDetails->country);  */
            $grandTotal = Product::getGrandTotal();
            // dd($grandTotal);
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
            $order->shipping_charges = Session::get('ShippingCharges');
            $order->grant_total = $grandTotal;
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

              //  reduce stoct script starrt
              $getProductStock = DB::table('products_attributes')->where('sku',$pro->product_code)->first();
              $newStock = $getProductStock->stock - $pro->quantity;
              if($newStock <0) {
                  $newStock = 0;
              }
              DB::table('products_attributes')->where('sku',$pro->product_code)->update(['stock' => $newStock]);
            //   dd("Original Stock :".$getProductStock->stock, "Stock to reduce :".$pro->quantity);
            }

            Session::put('order_id',$order_id);
            Session::put('grant_total',$grandTotal);

            if($data['payment_method'] == "COD")
            {
                $productDetails = Order::with('orders')->where('id', $order_id)->first();
                // $productDetails = json_decode(json_encode($productDetails));
                $userDetails = User::where('id', $user_id)->first();
                // for order email
                $email = $user_email;
                $messageData = [
                    'email' => $email,
                    'name' => $shippingDetails->name,
                    'order_id' => $order_id,
                    'productDetails' => $productDetails,
                    'userDetails' =>  $userDetails,
                ];
                Mail::send('emails.order',$messageData, function($message) use($email) {
                    $message->to($email)->subject('Order Placed - E-com Husin');
                });
                // end order email
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
        if(Session::get('adminDetails')['order_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        $orders = Order::with('orders')->orderBy('id','desc')->get();
        return view('admin.orders.view_orders')->with(\compact('orders'));
    }


    public function viewOrderDetails($order_id)
    {
        if(Session::get('adminDetails')['order_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(\json_encode($orderDetails));
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        $userDetails = json_decode(\json_encode($userDetails));

        return view('admin.orders.order_details')->with(\compact('orderDetails','userDetails'));
    }


    public function viewOrderInvoice($order_id)
    {
        if(Session::get('adminDetails')['order_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }   
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(\json_encode($orderDetails));
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        $userDetails = json_decode(\json_encode($userDetails));

        return view('admin.orders.order_invoice')->with(\compact('orderDetails','userDetails'));
    }


    public function viewPDFInvoice($order_id) {
        if(Session::get('adminDetails')['order_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }   
        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(\json_encode($orderDetails));
        $user_id = $orderDetails->user_id;
        $userDetails = User::where('id', $user_id)->first();
        $userDetails = json_decode(\json_encode($userDetails));
        $hello = "hello";
        return view('admin.orders.order_invoice')->with(\compact('orderDetails','userDetails','hello'));
    }


    public function updateOrderStatus(Request $request) 
    {
        if(Session::get('adminDetails')['order_access'] == 0) {
            return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');
         }
        if($request->isMethod('post'))
        {
            $data = $request->all();

            Order::where('id',$data['order_id'])->update([
                'order_status' => $data['order_status']
            ]);

            return redirect()->back()->with('flash_message_success','Order Status Has been Update Successfully');
        }
    }


    public function checkPincode(Request $request) {

        if($request->isMethod('post')) {
            $data = $request->all();
            $pincodeCount = DB::table('pincodes')->where('pincode',$data['pincode'])->count();
            if($pincodeCount > 0 ) {
                echo true;
            } else {
                echo false;
            }

        }
        // $data = $request->all();
        // echo "<pre>"; print_r($data); die;
    }


    public  function exportProducts() {
        return Excel::download(new productsExport,'products.xlsx');
    }


    public function deleteWishlistProduct($id = null) {
        DB::table('wish_list')->where('id', $id)->delete();
        return redirect()->back()->with('flash_message_success','Product has been delete from Wish List');
    }


    public function viewOrdersCharts() {
        $current_mount_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_mount_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1)->month)->count();
        $last_to_last_mount_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();
        $thre_month_back_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3)->month)->count();
         return view('admin.orders.view_orders_charts')->with(compact('current_mount_orders','last_mount_orders','last_to_last_mount_orders','thre_month_back_orders'));
    }




}