<?php

namespace App\Http\Controllers;

use App\Models\CrawlAreaGyyxs;
use App\Models\CrawlAreaThismonth;
use App\Models\CrawlAreaBeformonth;
use App\Models\CrawlAreaYear;
use App\Models\CrawlAreaToday;
use QL\QueryList;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use QL\Ext\CurlMulti;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function test()
    {

    }

}