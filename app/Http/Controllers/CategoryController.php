<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Category;
use DB;

class CategoryController extends Controller
{
    public function addCategory(Request $request) {
        
        if($request->isMethod('post')) { 
        $data = $request->all();
        // dd($data);
        $category = new Category;
        $category->name = $data['category_name'];
        $category->parent_id = $data['parent_id'];
        $category->description = $data['description'];
        $category->url = $data['url'];
        $category->meta_title = $data['meta_title'] ?: "";
        $category->meta_description = $data['meta_description'] ?: "";
        $category->meta_keywords = $data['meta_keywords'] ?? "";
        $category->status = $data['status'] ?? 0;
        $category->save();
        return redirect ('/admin/view-categories')->with('flash_message_success','category_added_successfully');

      }
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.categories.add_category')->with(compact('levels'));
    }

    public function editCategory(Request $request, $id = null) {

        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            Category::where(['id'=>$id])->update([
                'name'=>$data['category_name'],
                'description'=>$data['description'],
                'url'=>$data['url'],
                'meta_title' => $data['meta_title'] ?: "",
               'meta_description' => $data['meta_description'] ?: "",
                'meta_keywords' => $data['meta_keywords'] ?? "", 
                'status'=>$data['status'] ?? 0 ]);
            return redirect('/admin/view-categories')->with('flash_message_success','category_updated_successfully');
        }
        $categoryDetails = Category::where(['id'=>$id])->first();
        $levels = Category::where(['parent_id'=>0])->get();

        return view('admin.categories.edit_category')->with(compact('categoryDetails','levels'));
    }

    public function deleteCategory($id = null) {

        if(!empty($id)) {
            Category::where(['id'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','category_deleted_successfully');
        }
    }

    public function viewCategories() {

        $categories =DB::table('categories')->orderBy('created_at','desc')->get();

        return view ('admin.categories.view_categories')->with(compact('categories'));
    }

}
