<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Model\PageModel;
use App\Model\QueryModel;

class DashboardController extends Controller
{
    public $viewdata = [];

    public function __construct()
    {
        $this->page = new PageModel();
        $this->viewdata = $this->page->viewdata();
        $this->viewdata['page'] = $this->page;

        $this->query = new QueryModel();
        $this->viewdata['query'] = $this->query;

        // $this->module = $this->page->get_modid($this->mod_alias);
        // $this->viewdata['module'] = $this->module;
    }

    public function index()
    {
        return view('admin.dashboard', $this->viewdata);
    }
}
