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
    }

    public function index()
    {
        return view('admin.dashboard', $this->viewdata);
    }
}
