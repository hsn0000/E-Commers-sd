<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;

use App\Currency;
use DB;
use Date;

class CurrencyController extends Controller
{
    public $viewdata = [];
      
    protected $mod_alias = 'currencies';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }


    public function indexCurrency() {

        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);
  
        $currencies = $this->query->get_currencies()->orderByRaw('created_at DESC')->get();

        $this->viewdata['currencies'] = $currencies;
          
        $this->viewdata['toolbar'] = true;
  
        $this->viewdata['page_title'] = __('page.banner');

        return \view('admin.currencies.view_currencies', $this->viewdata);
    }


    public function addCurrency (Request $request) { 

        if($request->isMethod('post')) {

            $this->page->blocked_page($this->mod_alias, 'create');

            $data = $request->all();

            $_validates = [
              'currency_name' => 'required',
              'currency_simbol' => 'required',
              'currency_code' => 'required',
              'exchange_rate' => 'required',
            ];
    
            $validator = Validator::make($request->all(), $_validates);
    
            if($validator->fails())
            {
                return \redirect($this->module->permalink.'/add')
                        ->withErrors($validator)
                        ->withInput();
            }

            if($this->query->get_currencies(['currency_name' => $data['currency_name']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Currency Name '.$data['currency_name'].' has ben already exists');
            }
            elseif($this->query->get_currencies(['currency_simbol' => $data['currency_simbol']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Currency Simbol '.$data['currency_simbol'].' has ben already exists');
            }
            elseif($this->query->get_currencies(['currency_code' => $data['currency_code']])->count() > 0)
            {
              return \redirect($this->module->permalink.'/add')->with('msg_error','Currency Code '.$data['currency_code'].' has ben already exists');
            }

            $exchange_rate =  str_replace([",","Rp"," "],"",$data['exchange_rate']);

            $currency = new Currency;
            $currency->currency_name = $data['currency_name'];
            $currency->currency_simbol = $data['currency_simbol'];
            $currency->currency_code = $data['currency_code'];
            $currency->exchange_rate = $exchange_rate;
            $currency->status = $data['status'] ?? "0";
            $currency->save();

            return \redirect($this->module->permalink)->with('msg_success','Currency has been added successfully');
        }

        $this->page->blocked_page($this->mod_alias, 'create');

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.add_currencies');

        return view('admin.currencies.add_currency', $this->viewdata);
    }


    public function editCurrency(Request $request, $id = null ) {

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

        $currencyDetail = DB::table('currencies')->where('id',$data_id)->first();

        $this->viewdata['currencyDetail'] = $currencyDetail;

        $this->viewdata['toolbar_save'] = true;

        $this->viewdata['page_title'] = __('page.edit_currency');
 
        return \view('admin.currencies.edit_currency', $this->viewdata);
    }


    public function updateCurrencies(Request $request) 
    {
        $this->page->blocked_page($this->mod_alias, 'alter');

        $data = $request->all();

        $_validates = [
          'currency_name' => 'required',
          'currency_simbol' => 'required',
          'currency_code' => 'required',
          'exchange_rate' => 'required',
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
  
        if(DB::table('currencies')->where('currency_name', ucwords($request->input('currency_name')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','Currency Name '.$data['currency_name'].' has ben already exists');
        }
        elseif(DB::table('currencies')->where('currency_simbol', ucwords($request->input('currency_simbol')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','Currency Simbol '.$data['currency_simbol'].' has ben already exists');
        }
        elseif(DB::table('currencies')->where('currency_code', ucwords($request->input('currency_code')))->where('id', '!=', $data_id)->count() > 0)
        {
          return \redirect($this->module->permalink.'/edit')->with('msg_error','Currency Code '.$data['currency_code'].' has ben already exists');
        }

        $exchange_rate =  str_replace([",","Rp"," "],"",$data['exchange_rate']);

        $update =  DB::table('currencies')->where('id',$data_id)->update([
            'currency_name' => $data['currency_name'],
            'currency_simbol'  => $data['currency_simbol'],
            'currency_code' => $data['currency_code'],
            'exchange_rate' => $exchange_rate,
            'status' => $data['status'] ?? 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if(!$update)
        {
            return redirect($this->module->permalink.'/edit')->with('msg_error', 'Failed to update data to Storage')->withInput();
        }
  
        return redirect($this->module->permalink)->with('msg_success', 'Data Currencies '.ucwords($request->input('currency_name')).' has been updated');
  
    }


    public function deleteCurrency(Request $request) {
          
        $this->page->blocked_page($this->mod_alias,'drop');

        if(!$request->filled('data_id'))
        {
            return redirect($this->module->permalink)->with('msg_error', 'Data id not found');
        }
  
        $data_id = array_keys($request->input('data_id'));
  
        $currencies = DB::table('currencies')->where('id',$data_id)->first();

        $delete = DB::table('currencies')->where('id',$data_id)->delete();

        if(!$delete)
        {
            return redirect($this->module->permalink)->with('msg_error', 'Failed to delete data to Storage')->withInput();
        }
 
        return redirect($this->module->permalink)->with('msg_success', 'Currencies '.$currencies->currency_name.' has been deleted');
        
    }



}
