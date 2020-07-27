<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use DB;
use App\ShippingCharge;
use Date;

class ShippingController extends Controller
{
    public $viewdata = [];
      
    protected $mod_alias = 'shipping';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }


    public function indexShipping() {

        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);

        $shipping_charge = $this->query->get_shipping_charges()->get();
        //  $pincode = DB::table('pincodes')->get();

        $this->viewdata['shipping_charge'] = $shipping_charge;
        
        $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = __('page.shipping_charge');

        return view('admin.shippings.view_shipping', $this->viewdata);
    }


    public function editShipping(Request $request ) {

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

        $shippingDetails = $this->query->get_shipping_charges(['id' => $data_id])->first();

        $this->viewdata['shippingDetails'] = $shippingDetails;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.edit_shipping');

        return view('admin.shippings.edit_shiping', $this->viewdata);
    }


    public function updateShipping(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'alter');

        $data = $request->all();
  
        $_validates = [
          'country' => 'required',
          'country_code' => 'required',
          'shipping_charges' => 'required',
          'shipping_charges0_500g' => 'required',
          'shipping_charges501_1000g' => 'required',
          'shipping_charges1001_2000g' => 'required',
          'shipping_charges2001_5000g' => 'required',
        ];
  
        $validator = Validator::make($request->all(), $_validates);
  
        if($validator->fails())
        {
            return \redirect($this->module->permalink.'/edit')
                    ->withErrors($validator)
                    ->withInput();
        }
  
        $data_id = session('data_id');
  
        if(!$data_id)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Data id not found');
        }

        if(DB::table('shipping_charges')->where('country', ucwords($request->input('country')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','Title '.$data['country'].' has ben already exists');
        }
        elseif(DB::table('shipping_charges')->where('country_code', ucwords($request->input('country_code')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','country code '.$data['country_code'].' has ben already exists');
        }

        $shipping_charges =  str_replace([",","Rp"," "],"",$data['shipping_charges']);

        $update = DB::table('shipping_charges')->where('id',$data_id)->update([
            'country' => $data['country'],
            'country_code' => $data['country_code'],
            'shipping_charges' => $shipping_charges,
            'shipping_charges0_500g' => $data['shipping_charges0_500g'],
            'shipping_charges501_1000g' => $data['shipping_charges501_1000g'],
            'shipping_charges1001_2000g' => $data['shipping_charges1001_2000g'],
            'shipping_charges2001_5000g' => $data['shipping_charges2001_5000g'] ,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if(!$update)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
        }
  
        return redirect($this->module->permalink)->with('msg_success', 'Data Shipping '.ucwords($request->input('country')).' has been updated');

    }


    public function addShipping(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'create');

        return \redirect($this->module->permalink)->with('msg_error',"Shipping page doesn't exist yet");

    }


    public function deleteShipping(Request $request)
    {
        $this->page->blocked_page($this->mod_alias, 'drop');

        return \redirect($this->module->permalink)->with('msg_error',"Shipping page doesn't exist yet");

    }


}
