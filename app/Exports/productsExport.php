<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class productsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $productsData = Product::select('category_id','product_name','product_code','product_color','care','sleeve','description','price','weight')->where('status',1)->orderBy('id','Desc')->get();
        foreach($productsData as $key =>$product) {
            $catName = DB::table('categories')->select('name')->where('id',$product->category_id)->first();
            $productsData[$key]->category_id = $catName->name;
        }
        // $productsData = json_decode(json_encode($productsData));
        return $productsData;
    }
    public function headings(): array {
        return ['category_id','product_name','product_code','product_color','care','sleeve','description','price','weight'];
    }
}
