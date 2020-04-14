<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ShippingCharge;
use Date;

class ShippingController extends Controller
{
    public function viewShipping() {
         $shipping_charge = DB::table('shipping_charges')->get();
        //  $pincode = DB::table('pincodes')->get();
         return view('admin.shippings.view_shipping')->with(\compact('shipping_charge'));
    }


    public function editShipping(Request $request, $id = null ) {
        if($request->isMethod('post')) {
              $data = $request->all();
              $shipping_charges =  str_replace([","],"",$data['shipping_charges']);

              DB::table('shipping_charges')->where('id',$id)->update([
                  'country' => $data['country'] ?? "",
                  'country_code' => $data['country_code'] ?? "",
                  'shipping_charges' => $shipping_charges ?? "",
                  'shipping_charges0_500g' => $data['shipping_charges0_500g'] ?? "",
                  'shipping_charges501_1000g' => $data['shipping_charges501_1000g'] ?? "",
                  'shipping_charges1001_2000g' => $data['shipping_charges1001_2000g'] ?? "",
                  'shipping_charges2001_5000g' => $data['shipping_charges2001_5000g'] ?? "",
                  'updated_at' => date('Y-m-d H:i:s'),
              ]);
              return \redirect()->back()->with('flash_message_success','shipping charges updated successfully !');
        }
        $shippingDetails = DB::table('shipping_charges')->where('id',$id)->first();
        return view('admin.shippings.edit_shiping')->with(\compact('shippingDetails'));
    }




}
