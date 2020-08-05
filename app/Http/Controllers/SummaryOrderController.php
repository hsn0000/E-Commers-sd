<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;
use App\Order;
use DB;
use Carbon\Carbon;

class SummaryOrderController extends Controller
{
    public $viewdata = [];
    protected $mod_alias = 'summary-order';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }

     
    public function index(Request $request)
    {

        if($request->isMethod('post'))
        {
            $this->page->blocked_page($this->mod_alias);
            
            \session::forget(['data_id']);

            $orders_summary = $this->query->search_orders(['order_status' => $request->order_status], ['created_at' => $request->picked_date])->orderByRaw('created_at DESC')->get();

            $order_status = $this->query->get_orders()->selectRaw('order_status')->groupBy('order_status')->get();

            $this->viewdata['orders_summary'] = $orders_summary;
    
            $this->viewdata['order_status'] = $order_status;

            $this->viewdata['_order_status'] = $request->order_status;

            $this->viewdata['_picked_date'] = $request->picked_date;
    
            $this->viewdata['page_title'] = __('page.summary-order');
    
            return view('admin.summary.index_summary_order', $this->viewdata);
        }

        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);

        $orders_summary = $this->query->get_orders()->orderByRaw('created_at DESC')->get();

        $order_status = $this->query->get_orders()->selectRaw('order_status')->groupBy('order_status')->get();

        $this->viewdata['orders_summary'] = $orders_summary;

        $this->viewdata['order_status'] = $order_status;
 
        // $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = __('page.summary-order');

        return view('admin.summary.index_summary_order', $this->viewdata);
    }


    public function viewOrderInvoice($order_id = null)
    {
        $this->page->blocked_page($this->mod_alias);

        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(\json_encode($orderDetails));

        $user_id = $orderDetails->user_id;

        $userDetails = $this->query->get_data_users_front('id', $user_id)->first();

        $this->viewdata['orderDetails'] = $orderDetails;

        $this->viewdata['userDetails'] = $userDetails;

        $this->viewdata['page_title'] = __('page.view-orders-invoice');

        return view('admin.orders.order_invoice',$this->viewdata);
    }


    public function viewOrderDetails($order_id)
    {
        $this->page->blocked_page($this->mod_alias);

        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(\json_encode($orderDetails));

        $user_id = $orderDetails->user_id;

        $userDetails = $this->query->get_data_users_front('id', $user_id)->first();

        $this->viewdata['orderDetails'] = $orderDetails;

        $this->viewdata['userDetails'] = $userDetails;

        $this->viewdata['page_title'] = __('page.view-orders-detail');

        return view('admin.orders.order_details', $this->viewdata);
    }


}
