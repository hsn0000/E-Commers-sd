<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Coupon;
class CouponsController extends Controller
{
    public function addCoupon(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $coupon = New Coupon;
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = str_replace(["Rp",","],"",$data['amount']);
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = $data['status'] ?? 0;
            $coupon->save();

            return redirect('/admin/view-coupon/')->with('flash_message_success','Coupon has been added Successfully !');
        }
        return view('admin.coupons.add_coupon');
    }


    public function editCoupon(Request $request, $id = null)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            $coupon = Coupon::find($id);
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = $data['status'] ?? 0;
            $coupon->save();

            return redirect('/admin/view-coupon/')->with('flash_message_success','Coupon has been updated Successfully !');
        }
        $couponDetails = Coupon::find($id);
        // $couponDetails = json_decode(\json_encode($couponDetails));

        return \view('admin.coupons.edit_coupon')->with(\compact('couponDetails'));
    }


    public function viewCoupons()
    {
        $coupons = Coupon::orderBy('created_at','DESC')->get();
        // $coupons = json_decode(\json_encode($coupons));
        return view('admin.coupons.view_coupons')->with(\compact('coupons'));
    }

    public function deleteCoupons($id = null)
    {
        Coupon::where(['id' => $id])->delete();

        return redirect()->back()->with('flash_message_success','Coupon has been deleted successfully !');
    }


}
