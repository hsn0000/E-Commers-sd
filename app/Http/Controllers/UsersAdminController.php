<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Model\PageModel;
use App\Model\QueryModel;

use Jenssegers\Date\Date;
use Excel;
use App\Exports\usersExport;
use Carbon\Carbon;
use App\User;
use DB;

class UsersAdminController extends Controller
{
    
    public $viewdata = [];

    protected $mod_alias = 'user';

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

 
    public function viewUsers() {

        $this->page->blocked_page($this->mod_alias);

        $get_data = $this->query->get_data_users_front(['admin' =>  0 ])->orderByRaw('created_at DESC');

        $_data_table = [];

        if($get_data->count() > 0 )
        {
            foreach($get_data->get() as $key => $val)
            {
                $_status = null;
                if($val->status > 0 )
                {
                    $_status = '<span class="badge badge-info" style="margin-right: 10px;"><i class="icon icon-ok"></i> Yes</span>';
                }
                else
                {
                    $_status = '<span class="badge badge-important" style="margin-right: 10px;"><i class="icon icon-ban-circle"></i> No</span>';
                }

                $_data_table[] = [
                    'no' => ++$key,
                    'id' => $val->id,
                    'avatar' => $val->avatar,
                    'name' => $val->name,
                    'email' => $val->email,
                    'address' => $val->address,
                    'city' => $val->city,
                    'state' => $val->state,
                    'country' => $val->country,
                    'pincode' => $val->pincode,
                    'mobile' => $val->mobile,
                    'status' => $_status,
                    'status' => $_status,
                    'created_at' => Date::parse($val->created_at)->format('l, j F Y - H:i A'),
                    'updated_at' => Date::parse($val->updated_at)->format('l, j F Y - H:i A'),
                ];
            }
        }

        $this->viewdata['_data_table'] = $_data_table;

        $this->viewdata['page_title'] = "Users";

        return view('admin.users.view_users', $this->viewdata);
    }
    

    public function viewUsersCharts() {

        $this->page->blocked_page($this->mod_alias);

        $current_mount_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_mount_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1)->month)->count();
        $last_to_last_mount_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2)->month)->count();
        $thre_month_back_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(3)->month)->count();
        $four_month_back_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(4)->month)->count();
        $five_month_back_users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(5)->month)->count();
        
        $this->viewdata['current_mount_users'] = $current_mount_users;
        $this->viewdata['last_mount_users'] = $last_mount_users;
        $this->viewdata['last_to_last_mount_users'] = $last_to_last_mount_users;
        $this->viewdata['thre_month_back_users'] = $thre_month_back_users;
        $this->viewdata['four_month_back_users'] = $four_month_back_users;
        $this->viewdata['five_month_back_users'] = $five_month_back_users;

        $this->viewdata['page_title'] = "chart users";

        return view('admin.users.view_users_charts', $this->viewdata);
    }


    public function viewUsersCountriesCharts() {

        $this->page->blocked_page($this->mod_alias);

        $getUserCounties = $this->query->get_data_users_front()->select('ub.country',DB::raw('count(ub.country) as count'))->where('country','!=','')->groupBy('ub.country')->get();

        $getUserCountiesCollecArray = collect();
        foreach($getUserCounties as $countries) {
            $data['y'] = $countries->count;
            $data['name'] = $countries->country;
            $data['exploded'] = true;
            $getUserCountiesCollecArray->push($data);
        }

        $this->viewdata['getUserCountiesCollecArray'] = $getUserCountiesCollecArray;

        $this->viewdata['page_title'] = "chart users countries";

        return view('admin.users.view_users_countries_charts', $this->viewdata);
    }



    public function exportUsers()
    {
        return Excel::download(new usersExport, 'users.xlsx');
    }


}
