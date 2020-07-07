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
                    'name' => $val->name,
                    'address' => $val->address,
                    'city' => $val->city,
                    'state' => $val->state,
                    'country' => $val->country,
                    'pincode' => $val->pincode,
                    'mobile' => $val->mobile,
                    'email' => $val->email,
                    'status' => $_status,
                    'created_at' => Date::parse($val->created_at)->format('l, j F Y - H:i A'),
                ];
            }
        }

        $this->viewdata['_data_table'] = $_data_table;

        $this->viewdata['page_title'] = "Users";

        return view('admin.users.view_users', $this->viewdata);
    }


    public function exportUsers()
    {
        return Excel::download(new usersExport, 'users.xlsx');
    }


}
