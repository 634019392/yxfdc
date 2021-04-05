<?php

namespace App\Console\Commands\Cron;

use App\Models\CrawlDataXsmj;
use App\Models\CrawlDataXsts;
use App\Models\CrawlDataZgjj;
use App\Models\CrawlDataZdjj;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use QL\QueryList;
use QL\Ext\CurlMulti;
use Illuminate\Console\Command;

class CrawlData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:crawl-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取阳新房地产信息发布平台中的数据汇总';

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
        $data['xsmj1'] = $this->sjhz_xsmj('xsmj1');
        $data['xsmj2'] = $this->sjhz_xsmj('xsmj2');
        $data['xsmj3'] = $this->sjhz_xsmj('xsmj3');

        $data['xsts1'] = $this->sjhz_xsts('xsts1');
        $data['xsts2'] = $this->sjhz_xsts('xsts2');
        $data['xsts3'] = $this->sjhz_xsts('xsts3');

        $data['zgjj1'] = $this->sjhz_zgjj('zgjj1');
        $data['zgjj2'] = $this->sjhz_zgjj('zgjj2');
        $data['zgjj3'] = $this->sjhz_zgjj('zgjj3');

        $data['zdjj1'] = $this->sjhz_zdjj('zdjj1');
        $data['zdjj2'] = $this->sjhz_zdjj('zdjj2');
        $data['zdjj3'] = $this->sjhz_zdjj('zdjj3');

        //$today = date("Y-m-d");
        //$today_xsmj = DB::table('crawl_xsmj_data')->whereDate('created_at', $today)->get();
        foreach ($data as $k => $val) {
            if (strstr($k, 'xsmj')) {
                foreach ($val as $v) {
                    CrawlDataXsmj::create($v);
                }
            } elseif (strstr($k, 'xsts')) {
                foreach ($val as $v) {
                    CrawlDataXsts::create($v);
                }
            } elseif (strstr($k, 'zgjj')) {
                foreach ($val as $v) {
                    CrawlDataZgjj::create($v);
                }
            } elseif (strstr($k, 'zdjj')) {
                foreach ($val as $v) {
                    CrawlDataZdjj::create($v);
                }
            }
        }
    }

    /**
     * 爬取 http://119.100.21.219:81/Analysis_GuideRank.aspx 数据
     * $keyword:xsmj1、xsmj2、xsmj3、xsts(123)、zgjj(123)、zdjj(123)
     * @param $keyword
     * @return \Illuminate\Support\Collection
     */
    public function sjhz_xsmj($keyword)
    {
        $this->info('开始');
        try {
            $this->info('进入 sjhz_xsmj,当前关键字'.$keyword.'');
            $cache_path = public_path('/cache/Analysis_GuideRank');
            $html = 'http://119.100.21.219:81/Analysis_GuideRank.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $check_val = "img[src='images/" . $keyword . ".gif']";
            $table = $ql->find($check_val)
                ->parents("table[background='images/phbkuan.gif']")
                ->find("table[background='images/trbg.gif']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) use ($keyword) {
                $new_data = [];
                $data = $row->find('td')->texts()->all();
                $data_amend = QueryList::html($row->find('td')->html())->find('span')->title;
                $data[1] = $data_amend;
//            if (strstr($keyword, 'xsmj1') || strstr($keyword, 'xsts1') || strstr($keyword, 'zgjj1') || strstr($keyword, 'zdjj1')) {
//                $new_data['type'] = '1';
//            } elseif (strstr($keyword, 'xsmj2') || strstr($keyword, 'xsts2') || strstr($keyword, 'zgjj2') || strstr($keyword, 'zdjj2')) {
//                $new_data['type'] = '2';
//            } elseif (strstr($keyword, 'xsmj3') || strstr($keyword, 'xsts3') || strstr($keyword, 'zgjj3') || strstr($keyword, 'zdjj3')) {
//                $new_data['type'] = '3';
//            }
                if (strstr($keyword, '1')) {
                    $new_data['type'] = '1';
                } elseif (strstr($keyword, '2')) {
                    $new_data['type'] = '2';
                } elseif (strstr($keyword, '3')) {
                    $new_data['type'] = '3';
                }
                foreach ($data as $k => $v) {
                    switch ($k) {
                        case 0;
                            $new_data['xsmj_num'] = $v;
                            break;
                        case 1;
                            $new_data['project_name'] = $v;
                            break;
                        case 2;
                            $new_data['region'] = $v;
                            break;
                        case 3;
                            $new_data['area'] = $v;
                            break;
                        default:
                    }
                }
                return $new_data;
            });
            $this->info('正常结束');
            return $tableRows;

        } catch (\Exception $e) {
            \Log::error('sjhz_xsmj方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }
    }

    /**
     * 爬取 http://119.100.21.219:81/Analysis_GuideRank.aspx 数据
     * $keyword:xsts1、xsts2、xsts3
     * @param $keyword
     * @return \Illuminate\Support\Collection
     */
    public function sjhz_xsts($keyword)
    {
        $this->info('开始');
        try {
            $this->info('进入 sjhz_xsts,当前关键字'.$keyword.'');
            $cache_path = public_path('/cache/Analysis_GuideRank');
            $html = 'http://119.100.21.219:81/Analysis_GuideRank.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $check_val = "img[src='images/" . $keyword . ".gif']";
            $table = $ql->find($check_val)
                ->parents("table[background='images/phbkuan.gif']")
                ->find("table[background='images/trbg.gif']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) use ($keyword) {
                $new_data = [];
                $data = $row->find('td')->texts()->all();
                $data_amend = QueryList::html($row->find('td')->html())->find('span')->title;
                $data[1] = $data_amend;
                if (strstr($keyword, '1')) {
                    $new_data['type'] = '1';
                } elseif (strstr($keyword, '2')) {
                    $new_data['type'] = '2';
                } elseif (strstr($keyword, '3')) {
                    $new_data['type'] = '3';
                }
                foreach ($data as $k => $v) {
                    switch ($k) {
                        case 0;
                            $new_data['xsts_num'] = $v;
                            break;
                        case 1;
                            $new_data['project_name'] = $v;
                            break;
                        case 2;
                            $new_data['region'] = $v;
                            break;
                        case 3;
                            $new_data['sets'] = $v;
                            break;
                        default:
                    }
                }

                return $new_data;
            });

            $this->info('正常结束');
            return $tableRows;
        } catch (\Exception $e) {
            \Log::error('sjhz_xsts方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }
    }

    /**
     * 爬取 http://119.100.21.219:81/Analysis_GuideRank.aspx 数据
     * $keyword:zgjj1、zgjj2、zgjj3
     * @param $keyword
     * @return \Illuminate\Support\Collection
     */
    public function sjhz_zgjj($keyword)
    {
        $this->info('开始');
        try {
            $this->info('进入 sjhz_zgjj,当前关键字'.$keyword.'');

            $cache_path = public_path('/cache/Analysis_GuideRank');
            $html = 'http://119.100.21.219:81/Analysis_GuideRank.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $check_val = "img[src='images/" . $keyword . ".gif']";
            $table = $ql->find($check_val)
                ->parents("table[background='images/phbkuan.gif']")
                ->find("table[background='images/trbg.gif']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) use ($keyword) {
                $new_data = [];
                $data = $row->find('td')->texts()->all();
                $data_amend = QueryList::html($row->find('td')->html())->find('span')->title;
                $data[1] = $data_amend;
                if (strstr($keyword, '1')) {
                    $new_data['type'] = '1';
                } elseif (strstr($keyword, '2')) {
                    $new_data['type'] = '2';
                } elseif (strstr($keyword, '3')) {
                    $new_data['type'] = '3';
                }
                foreach ($data as $k => $v) {
                    switch ($k) {
                        case 0;
                            $new_data['zgjj_num'] = $v;
                            break;
                        case 1;
                            $new_data['project_name'] = $v;
                            break;
                        case 2;
                            $new_data['region'] = $v;
                            break;
                        case 3;
                            $new_data['zgjj_price'] = $v;
                            break;
                        default:
                    }
                }
                return $new_data;
            });

            $this->info('正常结束');
            return $tableRows;
        } catch (\Exception $e) {
            \Log::error('sjhz_zgjj方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }
    }

    /**
     * 爬取 http://119.100.21.219:81/Analysis_GuideRank.aspx 数据
     * $keyword:zdjj1、zdjj2、zdjj3
     * @param $keyword
     * @return \Illuminate\Support\Collection
     */
    public function sjhz_zdjj($keyword)
    {
        $this->info('开始');
        try {
            $this->info('进入 sjhz_zdjj,当前关键字'.$keyword.'');

            $cache_path = public_path('/cache/Analysis_GuideRank');
            $html = 'http://119.100.21.219:81/Analysis_GuideRank.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $check_val = "img[src='images/" . $keyword . ".gif']";
            $table = $ql->find($check_val)
                ->parents("table[background='images/phbkuan.gif']")
                ->find("table[background='images/trbg.gif']");

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) use ($keyword) {
                $new_data = [];
                $data = $row->find('td')->texts()->all();
                $data_amend = QueryList::html($row->find('td')->html())->find('span')->title;
                $data[1] = $data_amend;
                if (strstr($keyword, '1')) {
                    $new_data['type'] = '1';
                } elseif (strstr($keyword, '2')) {
                    $new_data['type'] = '2';
                } elseif (strstr($keyword, '3')) {
                    $new_data['type'] = '3';
                }
                foreach ($data as $k => $v) {
                    switch ($k) {
                        case 0;
                            $new_data['zdjj_num'] = $v;
                            break;
                        case 1;
                            $new_data['project_name'] = $v;
                            break;
                        case 2;
                            $new_data['region'] = $v;
                            break;
                        case 3;
                            $new_data['zdjj_price'] = $v;
                            break;
                        default:
                    }
                }
                return $new_data;
            });

            $this->info('正常结束');
            return $tableRows;
        } catch (\Exception $e) {
            \Log::error('sjhz_zdjj方法请求失败，终止此次请求');
            \Log::error($e);
            die;
        }
    }
}
