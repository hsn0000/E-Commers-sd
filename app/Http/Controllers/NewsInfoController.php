<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;

class NewsInfoController extends Controller
{
    public function addNews(Request $request) {
        if($request->isMethod('post')) {
            $request->validate([
                'description' => 'bail|required|',
            ]);
            $data = $request->all();
            // dd($data);
            DB::table('news_info')->insert([
                'description' => $data['description'],
                'url' => $data['url'] ?? '',
                'status' => $data['status'] ?? 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('view-news-info')->with('flash_message_success','Add News Information Successfully !');
        }
        return view('admin.newsinfo.add_news');
    }


    public function editNews(Request $request, $id = null) {
        if($request->isMethod('post')) {
            $data = $request->all();
            $request->validate([
                'description' => 'bail|required|',
            ]);
            // dd($data);
            DB::table('news_info')->where('id',$id)->update([
                'description' => $data['description'],
                'url' => $data['url'] ?? "",
                'status' => $data['status'] ?? 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('flash_message_success','Edit News Information Successfully !');
        }
        $newsDetail = DB::table('news_info')->where('id',$id)->first();
        return view('admin.newsInfo.edit_news',['newsDetail' => $newsDetail]);
    }


    public function viewNews() {
        $newsInfoAll = DB::table('news_info')->orderBy('updated_at','DESC')->get();
        return view('admin.newsInfo.view_news',['newsInfoAll' => $newsInfoAll]);
    }


    public function deleteNews($id = Null) {
        DB::table('news_info')->where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Deleted News Information Successfully !');
    }


    public function editStatusNews(Request $request) {
        if($request->ajax()) {
            $dataId = $request['id'];
            $whereStatus = DB::table('news_info')->where('id', $dataId)->select('status')->get();
            if($whereStatus['0']->status === 1) {
                DB::table('news_info')->where('id', $dataId)->update(['status' => 0]);
                return "success1";
            } else if ($whereStatus['0']->status === 0) {
                DB::table('news_info')->where('id', $dataId)->update(['status' => 1]);
                return "success0";
            }
            // return $whereStatus['0']->status;
        }
    }


    public function topageurlNews($id = null) {
        \abort(404);
    }


}
