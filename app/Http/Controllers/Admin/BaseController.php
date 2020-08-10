<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $pagesize;

    // paginate
    public function __construct()
    {
        $this->pagesize = config('page.pagesize');
    }
}
