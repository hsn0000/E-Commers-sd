<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Closure;
use Session;
use DB;
use App\Admin;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)  {
        if(empty(Session::has('adminSession'))) 
        {
            return redirect('/admin');
        } 
        else 
        {
            /*
            * get admin/sub admin detail
            */ 
            // $adminDetails = DB::table('admins')->where('username',Session::get('adminSession'))->first();
            // $adminDetails = json_decode(json_encode($adminDetails), true);

            // if($adminDetails['type'] == "Admin") {
            //     $adminDetails['categories_view_access'] = 1; 
            //     $adminDetails['categories_edit_access'] = 1; 
            //     $adminDetails['categories_full_access'] = 1; 
            //     $adminDetails['products_access'] = 1; 
            //     $adminDetails['order_access'] = 1; 
            //     $adminDetails['users_access'] = 1; 
            // }
            // Session::put('adminDetails',$adminDetails);
            // /*
            // * get current patch
            // */ 
            // $currentPatch = Route::getFacadeRoot()->current()->uri();
            // if($currentPatch == "admin/view-categories" && Session::get('adminDetails')['categories_view_access'] == 0) {
            //     return redirect()->back()->with('flash_message_error','You have no access for this module !');

            // } if($currentPatch == "admin/add-categories" && Session::get('adminDetails')['categories_edit_access'] == 0) {
            //     return redirect()->back()->with('flash_message_error','You have no access for this module !');

            // } if($currentPatch == "admin/view-product" && Session::get('adminDetails')['products_access'] == 0) {
            //     return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');

            // } if($currentPatch == "admin/add-product" && Session::get('adminDetails')['products_access'] == 0) {
            //     return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');

            // } if($currentPatch == "admin/view-orders" && Session::get('adminDetails')['order_access'] == 0) {
            //     return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');

            // } if($currentPatch == "admin/add-admins" && Session::get('adminDetails')['users_access'] == 0) {
            //     return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');

            // } if($currentPatch == "admin/view-admins" && Session::get('adminDetails')['users_access'] == 0) {
            //     return redirect('/admin/dashboard')->with('flash_message_error','You have no access for this module !');

            // }
            // dd($currentPatch, Session::get('adminDetails'));
        }
        return $next($request);
    }
}
