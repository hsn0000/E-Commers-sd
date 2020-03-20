<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function addCmsPage() {

        return view('admin.pages.add_cms_page');
    }
}
