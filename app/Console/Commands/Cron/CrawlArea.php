<?php

namespace App\Console\Commands\Cron;

use App\Models\CrawlAreaGyyxs;
use App\Models\CrawlAreaThismonth;
use App\Models\CrawlAreaBeformonth;
use App\Models\CrawlAreaYear;
use App\Models\CrawlAreaToday;
use QL\QueryList;

use Illuminate\Console\Command;

class CrawlArea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:crawl-area';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取阳新房地产信息发布平台中的区域分析';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->qyfx_gyyxs();
        $this->qyfx_year();
        $this->qyfx_thismonth();
        $this->qyfx_beformonth();
        $this->qyfx_today();
    }

    public function qyfx_gyyxs()
    {
        try {
            $cache_path = public_path('/cache/Analysis_Area');
            $html = 'http://119.100.21.219:81/Analysis_Area.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $table = $ql->find('.rd')->find("table[background='images/trbg.gif']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) {
                return $row->find('td')->texts()->all();
            });

            $data = [
                'supply_area' => $tableRows[0][2] ?: 0, // 供应面积
                'supply_sets' => $tableRows[0][3] ?: 0, // 供应套数
                'cjjj_price' => $tableRows[0][4] ?: 0, // 成交均价
            ];
            CrawlAreaGyyxs::create($data);
        } catch (\Exception $e) {
            \Log::error('gyyxs 方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }
    }

    public function qyfx_year()
    {
        try {
            $cache_path = public_path('/cache/Analysis_Area');
            $html = 'http://119.100.21.219:81/Analysis_Area.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $table = $ql->find('.rd')->find("td[valign='top']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) {
                return $row->find('td')->texts()->all();
            });

            $data = [
                'area' => $tableRows[25][1],
                'sets' => $tableRows[25][2],
                'price' => $tableRows[25][3]
            ];

            CrawlAreaYear::create($data);
        } catch (\Exception $e) {
            \Log::error('gyyxs 方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }

    }


    public function qyfx_thismonth()
    {
        try {
            $cache_path = public_path('/cache/Analysis_Area');
            $html = 'http://119.100.21.219:81/Analysis_Area.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $table = $ql->find('.rd')->find("td[valign='top']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) {
                return $row->find('td')->texts()->all();
            });

            $data = [
                'area' => $tableRows[38][1],
                'sets' => $tableRows[38][2],
                'price' => $tableRows[38][3]
            ];

            CrawlAreaThismonth::create($data);
        } catch (\Exception $e) {
            \Log::error('gyyxs 方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }

    }


    public function qyfx_beformonth()
    {
        try {
            $cache_path = public_path('/cache/Analysis_Area');
            $html = 'http://119.100.21.219:81/Analysis_Area.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $table = $ql->find('.rd')->find("td[valign='top']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) {
                return $row->find('td')->texts()->all();
            });

            $data = [
                'area' => $tableRows[51][1],
                'sets' => $tableRows[51][2],
                'price' => $tableRows[51][3]
            ];

            CrawlAreaBeformonth::create($data);
        } catch (\Exception $e) {
            \Log::error('gyyxs 方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }

    }


    public function qyfx_today()
    {
        try {
            $cache_path = public_path('/cache/Analysis_Area');
            $html = 'http://119.100.21.219:81/Analysis_Area.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $table = $ql->find('.rd')->find("td[valign='top']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) {
                return $row->find('td')->texts()->all();
            });

            $data = [
                'area' => $tableRows[64][1],
                'sets' => $tableRows[64][2],
                'price' => $tableRows[64][3]
            ];

            CrawlAreaToday::create($data);
        } catch (\Exception $e) {
            \Log::error('gyyxs 方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }

    }
}
