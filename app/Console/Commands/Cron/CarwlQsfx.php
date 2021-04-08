<?php

namespace App\Console\Commands\Cron;

use App\Models\CrawlQsfxData;
use QL\QueryList;
use Illuminate\Console\Command;

class CarwlQsfx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:crawl-qsfx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取趋势分析中的数据';

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
        $this->qsfx_xsmj();
    }

    public function qsfx_xsmj()
    {
        try {
            $config = [
                '__EVENTTARGET' => '',
                '__EVENTARGUMENT' => '',
                '__VIEWSTATE' => '/wEPDwUKLTI1ODY2ODI2Ng9kFgICAw9kFgQCAw9kFhQCAQ8PFgIeBFRleHQFBDE2MzhkZAIDDw8WAh8ABQM3MDhkZAIFDw8WAh8ABQQwLjAwZGQCBw8PFgIfAAUEMC4wMGRkAgkPDxYCHwAFATBkZAILDw8WAh8ABQEwZGQCDQ8PFgIfAAUCLS1kZAIPDw8WAh8ABQItLWRkAhEPDxYCHwAFAi0tZGQCEw8PFgIfAAUHNDM4Mi4zNGRkAgUPDxYEHgRUeXBlAgEeCVR5cGVWYWx1ZQUCdHNkFgoCAQ8PFgYfAAUX6ZSA5ZSu6Z2i56ev5YiG5p6QKOOOoSkeCUZvcmVDb2xvcgojHgRfIVNCAgRkZAIDDw8WBh8ABRfplIDllK7lpZfmlbDliIbmnpAo5aWXKR8DCo0BHwQCBGRkAgUPDxYGHwAFF+S+m+W6lOmdouenr+WIhuaekCjjjqEpHwMKIx8EAgRkZAIHDw8WBh8ABRfkvpvlupTlpZfmlbDliIbmnpAo5aWXKR8DCiMfBAIEZGQCCQ8WAh4LXyFJdGVtQ291bnQCDBYYAgEPZBYCZg8VDRLluILlnLrljJbllYblk4HmiL8DOTAwBDExNzYDNjcxAjE2ATABMAEwATABMAEwATABMGQCAg9kFgJmDxUNDOmbhui1hOW7uuaIvwEwATABMAEwATABMAEwATABMAEwATABMGQCAw9kFgJmDxUND+mFjeWll+WVhuWTgeaIvwEwATABMAEwATABMAEwATABMAEwATABMGQCBA9kFgJmDxUNEuWFrOWFseenn+i1geS9j+aIvwEwATABMAEwATABMAEwATABMAEwATABMGQCBQ9kFgJmDxUNDOW7ieenn+S9j+aIvwEwATABMAEwATABMAEwATABMAEwATABMGQCBg9kFgJmDxUNGOmZkOS7t+aZrumAmuWVhuWTgeS9j+aIvwEwATABMAEwATABMAEwATABMAEwATABMGQCBw9kFgJmDxUNEue7j+a1jumAgueUqOS9j+aIvwEwATABMAEwATABMAEwATABMAEwATABMGQCCA9kFgJmDxUND+WumumUgOWVhuWTgeaIvwEwATABMAEwATABMAEwATABMAEwATABMGQCCQ9kFgJmDxUNCeWKqOi/geaIvwEwATABMAEwATABMAEwATABMAEwATABMGQCCg9kFgJmDxUNCeemj+WIqeaIvwEwATABMAEwATABMAEwATABMAEwATABMGQCCw9kFgJmDxUNBuWFtuS7lgEwATABMAEwATABMAEwATABMAEwATABMGQCDA9kFgJmDxUNCeiHquW7uuaIvwEwATABMAEwATABMAEwATABMAEwATABMGRk/5Ugkil5dk45NHd1DtCj/vBBbFI=',
                '__EVENTVALIDATION' => '/wEWBQKGnMGkBgKY8qW9CwKY8rG9CwKY8q29CwKY8pm9C7Y0nrYVF8q4PRDCLA81Od/ASn49'
            ];
            $config['__EVENTTARGET'] = 'SaledAndApply1$LinkButton1';
            $cache_path = public_path('/cache/Analysis_Saled');
            $html = 'http://119.100.21.219:81/Analysis_Saled.aspx';
            $ql1 = QueryList::post($html, $config, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);
            $table1 = $ql1->find('.rd');
            $tableRows1 = $table1->find('tr:gt(0)')->map(function ($row) {
                return $row->find('td')->texts()->all();
            });
            $data1 = [
                'type' => '1',
                'jan' => $tableRows1[1][1],
                'feb' => $tableRows1[1][2],
                'mar' => $tableRows1[1][3],
                'apr' => $tableRows1[1][4],
                'may' => $tableRows1[1][5],
                'jun' => $tableRows1[1][6],
                'jul' => $tableRows1[1][7],
                'aug' => $tableRows1[1][8],
                'sep' => $tableRows1[1][9],
                'oct' => $tableRows1[1][10],
                'nov' => $tableRows1[1][11],
                'dec' => $tableRows1[1][12],
            ];

            $config['__EVENTTARGET'] = 'SaledAndApply1$LinkButton2';
            $ql2 = QueryList::post($html, $config, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);
            $table2 = $ql2->find('.rd');
            $tableRows2 = $table2->find('tr:gt(0)')->map(function ($row) {
                return $row->find('td')->texts()->all();
            });
            $data2 = [
                'type' => '2',
                'jan' => $tableRows2[1][1],
                'feb' => $tableRows2[1][2],
                'mar' => $tableRows2[1][3],
                'apr' => $tableRows2[1][4],
                'may' => $tableRows2[1][5],
                'jun' => $tableRows2[1][6],
                'jul' => $tableRows2[1][7],
                'aug' => $tableRows2[1][8],
                'sep' => $tableRows2[1][9],
                'oct' => $tableRows2[1][10],
                'nov' => $tableRows2[1][11],
                'dec' => $tableRows2[1][12],
            ];

            $res1 = CrawlQsfxData::query()->whereYear('created_at', date('Y', time()))->where(['type' => '1'])->first();
            $res2 = CrawlQsfxData::query()->whereYear('created_at', date('Y', time()))->where(['type' => '2'])->first();
            if (!$res1) {
                CrawlQsfxData::create($data1);
            } else {
                $res1->update($data1);
            }
            if (!$res2) {
                CrawlQsfxData::create($data2);
            } else {
                $res2->update($data2);
            }
        } catch (\Exception $e) {
            \Log::error('qsfx_xsmj方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }
    }
}
