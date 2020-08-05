<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

use App\Model\PageModel;
use App\Model\QueryModel;
use DB;
use Carbon\Carbon;

use App\Order;
use App\User;

class OrderController extends Controller
{
    public $viewdata = [];
    protected $mod_alias = 'orders-admin';

    public function __construct() {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;
        
        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;
    
        $this->module = $this->page->get_modid($this->mod_alias);
        $this->viewdata['module'] = $this->module;
    }


    public function indexOrders() 
    {
        $this->page->blocked_page($this->mod_alias);

        \session::forget(['data_id']);

        $orders = Order::with('orders')->orderBy('id','desc')->get();

        $this->viewdata['orders'] = $orders;
        
        // $this->viewdata['toolbar'] = true;

        $this->viewdata['page_title'] = __('page.orders-admin');

        return view('admin.orders.view_orders', $this->viewdata);
    }


    public function updateOrderStatus(Request $request) 
    {
        $this->page->blocked_page($this->mod_alias);

        if($request->isMethod('post'))
        {
            $data = $request->all();

            Order::where('id',$data['order_id'])->update([
                'order_status' => $data['order_status']
            ]);

            return redirect()->back()->with('msg_success','Order Status Has been Update Successfully');
        }
    }

    
    public function viewPDFInvoice($order_id) 
    {   
        $this->page->blocked_page($this->mod_alias);

        $orderDetails = Order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(\json_encode($orderDetails));

        $user_id = $orderDetails->user_id;

        $userDetails = $this->query->get_data_users_front('id', $user_id)->first();

        $this->viewdata['orderDetails'] = $orderDetails;

        $this->viewdata['userDetails'] = $userDetails;

        $this->viewdata['hello'] = "hello";

        $this->viewdata['page_title'] = __('page.view-orders-invoice');

        return view('admin.orders.order_invoice',$this->viewdata);
    }


    public function viewOrdersCharts() {

        $this->page->blocked_page($this->mod_alias);

        $current_mount_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_mount_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1)->month)->count();
        $last_to_last_mount_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();
        $thre_month_back_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3)->month)->count();
        $four_month_back_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(4)->month)->count();
        $five_month_back_orders = Order::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(5)->month)->count();

        $this->viewdata['current_mount_orders'] = $current_mount_orders;

        $this->viewdata['last_mount_orders'] = $last_mount_orders;

        $this->viewdata['last_to_last_mount_orders'] = $last_to_last_mount_orders;

        $this->viewdata['thre_month_back_orders'] = $thre_month_back_orders;

        $this->viewdata['four_month_back_orders'] = $four_month_back_orders;

        $this->viewdata['five_month_back_orders'] = $five_month_back_orders;

        $this->viewdata['hello'] = "hello";

        $this->viewdata['page_title'] = __('page.view-orders-chart');

         return view('admin.orders.view_orders_charts',$this->viewdata);
    }



}
