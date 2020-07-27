<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Model\PageModel;
use App\Model\QueryModel;

use Illuminate\Support\Facades\Validator;
use DB;
use App\Coupon;

class CouponsController extends Controller
{

    public $viewdata = [];

    protected $mod_alias = 'coupons';

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

    public function indexCoupons() 
    {
        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);

        $coupons = $this->query->get_coupons()->orderByRaw('created_at DESC')->get();

        $this->viewdata['coupons'] = $coupons;
        
        $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = "coupons";


        return view('admin.coupons.view_coupons', $this->viewdata);
    }


    public function addCoupon(Request $request)
    {
        if($request->isMethod('post'))
        {
            $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();

            $_validates = [
                'coupon_code' => 'required',
                'amount' => 'required',
                'amount_type' => 'required',
                'expiry_date' => 'required'
            ];
    
            $validator = Validator::make($request->all(), $_validates);
    
            if($validator->fails())
            {
                return \redirect($this->module->permalink.'/add')
                        ->withErrors($validator)
                        ->withInput();
            }

            if($data['amount_type'] == 'null')
            {
                return \redirect($this->module->permalink.'/add')->with('msg_error','please select amount type first');
            }

            $coupon_code_count = $this->query->get_coupons(['coupon_code' => $data['coupon_code']])->count();
            if($coupon_code_count > 0 )
            {
                return \redirect($this->module->permalink.'/add')->with('msg_error','coupon code '.$data['coupon_code'].' already exists !');
            } 
    
            $coupon = New Coupon;
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = str_replace(["Rp",",","%"," "],"",$data['amount']);
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = $data['status'] ?? 0;
            $coupon->in_use = 0;
            $coupon->save();

            return redirect($this->module->permalink)->with('msg_success','coupon_has_been_added_successfully');
        }

        $this->page->blocked_page($this->mod_alias, 'create');

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = "add coupons";

        return view('admin.coupons.add_coupon',$this->viewdata);
    }


    public function generateCoupons(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'create');

        $val = md5($request->all()['val']);

        return $val;
    }


    public function editCoupon(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');

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

        $couponDetails = $this->query->get_coupons()->where('id', $data_id)->first();

        $this->viewdata['couponDetails'] = $couponDetails;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('admin.edit_coupons');

        return \view('admin.coupons.edit_coupon', $this->viewdata);
    }


    public function updateCoupons(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');

        $data_id = session('data_id');

        $data = $request->all();

        if(!$data_id)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        $_validates = [
            'coupon_code' => 'required',
            'amount' => 'required',
            'amount_type' => 'required',
            'expiry_date' => 'required'
        ];

        $validator = Validator::make($request->all(), $_validates);

        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/edit')
                    ->withErrors($validator)
                    ->withInput();
        }

        if($data['amount_type'] == 'null')
        {
            return \redirect($this->module->permalink.'/edit')->with('msg_error','please select amount type first');
        }

        $coupon_code_count = $this->query->get_coupons()->where('coupon_code', $data['coupon_code'])->where('id', '!=', $data_id)->count();

        if($coupon_code_count > 0 )
        {
            return \redirect($this->module->permalink.'/edit')->with('msg_error','coupon code '.$data['coupon_code'].' already exists !');
        }

        $coupon = Coupon::find($data_id);

        $coupon->coupon_code = $data['coupon_code'];
        $coupon->amount = str_replace(["Rp",",","%"," "],"",$data['amount']);
        $coupon->amount_type = $data['amount_type'];
        $coupon->expiry_date = $data['expiry_date'];
        $coupon->status = $data['status'] ?? 0;
        $coupon->save();

        return redirect($this->module->permalink)->with('msg_success','coupon_has_been_updated_successfully');
     
    }


    public function deleteCoupons(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');

        if(!$request->filled('data_id'))
        {
            return \redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }

        $data_id = array_keys($request->input('data_id'));
        
        /*get data by ID*/ 
        $data_edit = DB::table('coupons')->where(['id' => $data_id])->first();

        /* deleting the user group */ 
        $delete = DB::table('coupons')->where(['id' => $data_id])->delete();

        if(!$delete)
        {
            return \redirect($this->module->permalink)->with('msg_error','Failed to delete data to Storage')->withInput();
        }

        return redirect($this->module->permalink)->with('msg_success','Data group '.$data_edit->coupon_code.' has been deleted');
    }


}
