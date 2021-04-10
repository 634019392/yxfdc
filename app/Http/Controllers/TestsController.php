<?php

namespace App\Http\Controllers;

use App\Models\CrawlAreaGyyxs;
use App\Models\CrawlAreaThismonth;
use App\Models\CrawlDataZdjj;
use App\Models\CrawlDataZgjj;
use App\Models\CrawlDataXsts;
use App\Models\CrawlDataXsmj;
use App\Models\CrawlExceptionData;
use App\Models\CrawlHslxfxData;
use App\Models\CrawlQsfxData;
use QL\QueryList;
use GuzzleHttp\Exception\RequestException;
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