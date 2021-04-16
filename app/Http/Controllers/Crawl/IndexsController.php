<?php

namespace App\Http\Controllers\Crawl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexsController extends Controller
{
    public function Index()
    {
        return view('crawl.index');
    }
}
