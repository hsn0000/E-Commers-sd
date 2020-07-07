<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use App\Product;
use App\Category;
use App\ProductsImage;
use App\ProductsAttribute; 
use Image;
use DB;
use Excel;
use App\Exports\productsExport;

class ProductAdminController extends Controller
{
    
    public $viewdata = [];

    protected $mod_alias = 'production';

    public function __construct()
    {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;

        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;

        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }



    public function indexProducts()
    {
        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);

        $products = $this->query->get_product()->orderByRaw('created_at DESC')->get();

        $this->viewdata['products'] = $products;

        $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = __('admin.products');

        return view('admin.products.index_products', $this->viewdata);
    }


    public function addProduct(Request $request) 
    {

        if($request->isMethod('post')) 
        {
            $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();

            $_validates = [
                'category_id' => 'required',
                'product_name' => 'required',
                'product_code' => 'required',
                'description' => 'required',
                'care' => 'required',
                'price' => 'required',
                'image' => 'required',
            ];
    
            $validator = Validator::make($request->all(), $_validates);
    
            if($validator->fails())
            {
                return \redirect($this->module->permalink.'/add')
                        ->withErrors($validator)
                        ->withInput();
            }

            $price = str_replace(["Rp",","],"",$data['price']);

            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'] ?? "";
            $product->description = $data['description'];
            $product->sleeve = $data['sleeve'] ?? "";
            $product->pattern = $data['pattern'] ?? "";
            $product->care = $data['care'];
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

        return \redirect($this->module->permalink)->with('msg_success','product_has_been_added_successfully'); 

        }

        $this->page->blocked_page($this->mod_alias, 'create');

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

        $this->viewdata['categories_dropdown'] = $categories_dropdown;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('admin.add_products');

        return view('admin.products.add-product', $this->viewdata);
    }





    /*
        attribute
    */ 

    public function addImages(Request $request, $id=null)
    {
        $this->page->blocked_page($this->mod_alias, 'create');

        if($request->isMethod('post'))
        {
            $this->page->blocked_page($this->mod_alias, 'create');
            // add images
            $data = $request->all();

            $_validates = [
                'image' => 'required'
            ];

            $validator = Validator::make($request->all(), $_validates);

            if($validator->fails())
            {
                return \redirect($this->module->permalink.'/add-images/'.$id)
                        ->withErrors($validator)
                        ->withInput();
            }

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
          return redirect($this->module->permalink.'/add-images/'.$id)->with('msg_success','product_image_has_ben_added');
        }

        $productDetails = Product::with('attributes')->where(['id' => $id])->first();

        $productsImages = ProductsImage::where(['product_id' => $id])->get();

        $this->viewdata['productDetails'] = $productDetails;

        $this->viewdata['productsImages'] = $productsImages;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('admin.product_image');

        return view('admin.products.add_images', $this->viewdata);

    }


    public function deleteAltImage($id=null)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');
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
 
        return \redirect()->back()->with('msg_success','product_image_has_been_deleted');
    }


    public function addAtributes(Request $request, $id=null)
    {
        $this->page->blocked_page($this->mod_alias, 'create');

        if($request->isMethod('post'))
        {
            $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();

            foreach($data['sku'] as $key => $val)
            {
                if(!$val)
                {
                    return redirect($this->module->permalink.'/add-attribute/'.$id)->with('msg_error',' sku value is empty !');
                }
            }

            foreach($data['size'] as $key => $val)
            {
                if(!$val)
                {
                    return redirect($this->module->permalink.'/add-attribute/'.$id)->with('msg_error',' size value is empty !');
                }
            }

            foreach($data['price'] as $key => $val)
            {
                if(!$val)
                {
                    return redirect($this->module->permalink.'/add-attribute/'.$id)->with('msg_error',' price value is empty !');
                }
            }

            foreach($data['stock'] as $key => $val)
            {
                if(!empty($val))
                {
                    //    SKU Check 
                    $attrCountSKU = ProductsAttribute::where('sku',$val)->count();

                    if($attrCountSKU > 0 )
                    {
                        return redirect($this->module->permalink.'/add-attribute/'.$id)->with('msg_error','sku_already_exists');
                    }
                    // Size Check
                    $attrCountSize = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();

                    if($attrCountSize > 0)
                    {
                        return redirect($this->module->permalink.'/add-attribute/'.$id)->with('msg_error','"'.$data['size'][$key].'" SIZE Already Exists For This Product, Please Add Another SIZE. !');
                    }

                    $price = preg_replace('/[Rp, ]/','',$data['price'][$key]);

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $data['sku'][$key];
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $price ;
                    $attribute->stock = $data['stock'][$key];
                    $attribute->save();
                }
                else
                {
                    return redirect($this->module->permalink.'/add-attribute/'.$id)->with('msg_error',' stock value is empty !');
                }

            }

           return redirect($this->module->permalink.'/add-attribute/'.$id)->with('msg_success','product_attributes_has_been_added');
        }

        $productDetails = Product::with('attributes')->where(['id' => $id])->orderByRaw('created_at DESC')->first();

        $this->viewdata['productDetails'] = $productDetails;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('admin.product_attribute');

        return view('admin.products.add_attributes', $this->viewdata);

    }


    public function editAtributes(Request $request, $id = null)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');
        if($request->isMethod('post'))
        {
            $data = $request->all();
            foreach($data['idAttr'] as $key => $attr )
            {
                $price = preg_replace('/[Rp, ]/','',$data['price'][$key]);

                ProductsAttribute::where(['id'=>$data['idAttr'][$key]])->update([
                    'price' => $price,
                    'stock' => $data['stock'][$key]
                ]);
            }
            return redirect()->back()->with('msg_success','product_attribute_has_been_update');
        }

    }


    public function deleteAttribute($id=null)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');
        
        $sku = DB::table('products_attributes')->where('id', $id);

        if($sku->count() == 0 )
        {
            return redirect()->back()->with('msg_error','Data is empty');
        }

        $_sku = $sku->first()->sku;

        ProductsAttribute::where(['id' => $id])->delete();

        return redirect()->back()->with('msg_success',' '.$_sku.' attribute_has_been_deleted');
    }


    public  function exportProducts() {

        $this->page->blocked_page($this->mod_alias, 'create');

        return Excel::download(new productsExport,'products.xlsx');
    }


}
