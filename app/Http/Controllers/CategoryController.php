<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use App\Category;
use DB;
use Session;
use Date;

class CategoryController extends Controller
{

    public $viewdata = [];

    protected $mod_alias = 'categori';

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


    public function indexCategories() {
        
        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);

        $get_categori = $this->query->get_categories()->orderByRaw('created_at DESC');

        $_data_table = [];

        if($get_categori->count() > 0 )
        {
            foreach($get_categori->get() as $key => $val)
            {
                $_status = null;
                if($val->status > 0 )
                {
                    $_status = '<span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> Yes</span>';
                }
                else
                {
                    $_status = '<span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> No</span>';
                }

                foreach($get_categori->get() as $key => $values)
                {
                    if($val->parent_id ==  $values->id)
                    {
                       $val->maincategori = '<span class="label lable-info" > '.$values->name.' </span>';
                    }                
                }

                if($val->parent_id > 0)
                {
                    $name = '<span class="badge" > '.$val->name.' </span>';
                }
                else
                {
                    $name = '<span class="badge badge-inverse" > '.$val->name.' </span>';
                }

                $_data_table[] = [
                    'no' => ++$key,
                    'id' => $val->id,
                    'parent_id' => $val->parent_id,
                    'maincategori' => isset($val->maincategori) ? $val->maincategori : '<span class="label label-inverse lable-categori" > Main Categori </span>',
                    'name' => $name,
                    'description' => $val->description,
                    'url' => $val->url,
                    'meta_title' => $val->meta_title,
                    'meta_description' => $val->meta_description,
                    'meta_keywords' => $val->meta_keywords,
                    'status' => $_status,
                    'created_at' => Date::parse($val->created_at)->format('l, j F Y - H:i A'),
                ];
            }
        }


        $this->viewdata['_data_table'] = $_data_table;

        $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = __('admin.categori');

        return view ('admin.categories.index_categories', $this->viewdata);
    }


    public function addCategory(Request $request) {

        $this->page->blocked_page($this->mod_alias, 'create');

        $get_levels = $this->query->get_categories(['parent_id'=> 0 ])->get();

        $this->viewdata['levels'] = $get_levels;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('admin.categori');


        return view('admin.categories.add_category', $this->viewdata);
    }


    public function saveCategory(Request $request) {

        $this->page->blocked_page($this->mod_alias, 'create');

        $_validates = [
            'category_name' => 'required',
            'parent_id' => 'required',
            'url' => 'required',
        ];

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/add')
                    ->withErrors($validator)
                    ->withInput();
        }

        /*
            Check category name
        */
        $category_name = DB::table('categories')->where('name', ucwords($request->input('category_name')))->select('name')->count();

        if($category_name > 0)
        {    
            return redirect($this->module->permalink.'/add')
                        ->with('msg_error', 'Category name '.ucwords($request->input('category_name')).' already exists')
                        ->withInput();
        }

        $data = $request->all();

        $category = new Category;
        $category->name = $data['category_name'];
        $category->parent_id = $data['parent_id'];
        $category->description = $data['description'] ?? '';
        $category->url = $data['url'];
        $category->meta_title = $data['meta_title'] ?: "";
        $category->meta_description = $data['meta_description'] ?: "";
        $category->meta_keywords = $data['meta_keywords'] ?? "";
        $category->status = $data['status'] ?? 0;
        $category->save();

        $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = __('admin.categori');

        return redirect($this->module->permalink)->with('msg_success','Category '.$data['category_name'].' has save to strorage');
    }


    public function editCategory(Request $request) {

        $this->page->blocked_page($this->mod_alias,'alter');

        if(!$request->filled('data_id') && !session('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error','Data id not found');
        }

        if(!session('data_id'))
        {
            $data_id = array_keys($request->input('data_id'));
            $data_id = $data_id[0];
            session(['data_id' => $data_id]);
        } 
        else
        {
            $data_id = \session('data_id');
        } 

        $get_categori = $this->query->get_categories(['id' => $data_id])->first();

        $get_categori_levels = $this->query->get_categories(['parent_id' => 0])->get();

        $this->viewdata['categoryDetails'] = $get_categori;

        $this->viewdata['levels'] = $get_categori_levels;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('admin.categori');

        return view('admin.categories.edit_category', $this->viewdata);
    }


    public function updateCategory(Request $request)
    {
        $this->page->blocked_page($this->mod_alias,'alter');

        $data_id = session('data_id');

        if(!$data_id)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        /**
         * Get Data by ID
         */

        $data_edit = DB::table('categories')->where(['id' => $data_id])->first();

        if(!isset($data_edit->name))
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        $_validates = [
            'category_name' => 'required',
            'parent_id' => 'required',
            'url' => 'required',
        ];

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/edit')
                    ->withErrors($validator)
                    ->withInput();
        }

        /*
             Check category name
        */
        $category_name = DB::table('categories')->where('name', ucwords($request->input('category_name')))->where('id', '!=', $data_edit->id)->select('name')->count();

        if($category_name > 0)
        {    
            return redirect($this->module->permalink.'/edit')
                        ->with('msg_error', 'Category name '.ucwords($request->input('category_name')).' already exists')
                        ->withInput();
        }

        $data = $request->all();

        $update = Category::where(['id'=>$data_id])->update([
            'name' => $data['category_name'],
            'description' => $data['description'] ?? "",
            'url' => $data['url'],
            'meta_title' => $data['meta_title'] ?: "",
            'meta_description' => $data['meta_description'] ?: "",
            'meta_keywords' => $data['meta_keywords'] ?? "", 
            'status'=>$data['status'] ?? 0 
        ]);

        if(!$update)
        {
            return redirect($this->module->permalink.'/admin/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
        }

        return redirect($this->module->permalink)->with('msg_success', 'Data Category '.ucwords($request->input('category_name')).' has been updated');

    }


    public function deleteCategory(Request $request) {

        $this->page->blocked_page($this->mod_alias,'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }

        $data_id = array_keys($request->input('data_id'));

        /*
            Get Data by ID
        */
        $data_edit = DB::table('categories')->where(['id' => $data_id])->first();

        
        /*
             Checking category
         */
        if($data_edit->parent_id === 0 )
        {
            $total_category = DB::table('categories')->where(['parent_id' => $data_edit->id])->count();

            if($total_category > 0)
            {
                return redirect($this->module->permalink)->with('msg_error', 'Main Category Group '.$data_edit->name.' have '.$total_category.' Sub Category');
            }
        }

        /*
             Deleting the User Group
        */

        $delete  = DB::table('categories')->where(['id' => $data_edit->id])->delete();

        if(!$delete)
        {
            return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
        }

        return redirect($this->module->permalink)->with('msg_success', 'Categories '.$data_edit->name.' has been deleted');
        
    }



}
