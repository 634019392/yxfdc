<?php

namespace App\Console\Commands\Cron;

use QL\QueryList;
use GuzzleHttp\Exception\RequestException;
use App\Models\CrawlHslxfxData;
use Illuminate\Console\Command;

class CrawlHslxfx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:crawl-hslxfx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬取黄石信息类型分析';
    //类型分析中的供应与销售(首次默认爬取、之后爬取为每年12-31日)、今年销售统计(同理)、本月销售统计(首次不爬取，每个月最后一天才爬取)

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
        $this->hs_lxfx();
    }

    public function hs_lxfx()
    {
        try {
            $cache_path = public_path('/cache/Hs_Analysis_StatData');
            $html = 'http://58.51.240.121:8503/Analysis_StatData.aspx';
            $ql = QueryList::get($html, null, [
                'cache' => $cache_path,
                'cache_ttl' => 600 // 缓存有效时间，单位：秒，可以不设置缓存有效时间
            ]);

            $table = $ql->find('.rd table');

            $tableRows = $table->find('tr:gt(0)')->map(function ($row) {
                return $data = $row->find('td')->texts()->all();
            });

            $data = [
                0 => [
                    ['type' => '0', 'region' => '0', 'area' => $tableRows[0][2], 'sets' => $tableRows[0][3], 'price' => $tableRows[0][4]?:0],
                    ['type' => '0', 'region' => '1', 'area' => $tableRows[2][2], 'sets' => $tableRows[2][3], 'price' => $tableRows[2][4]?:0],
                    ['type' => '0', 'region' => '2', 'area' => $tableRows[4][2], 'sets' => $tableRows[4][3], 'price' => $tableRows[4][4]?:0],
                    ['type' => '0', 'region' => '3', 'area' => $tableRows[6][2], 'sets' => $tableRows[6][3], 'price' => $tableRows[6][4]?:0],
                    ['type' => '0', 'region' => '4', 'area' => $tableRows[8][2], 'sets' => $tableRows[8][3], 'price' => $tableRows[8][4]?:0],
                ],
                1 => [
                    ['type' => '1', 'region' => '0', 'area' => $tableRows[11][1], 'sets' => $tableRows[11][2], 'price' => $tableRows[11][3]?:0],
                    ['type' => '1', 'region' => '1', 'area' => $tableRows[12][1], 'sets' => $tableRows[12][2], 'price' => $tableRows[12][3]?:0],
                    ['type' => '1', 'region' => '2', 'area' => $tableRows[13][1], 'sets' => $tableRows[13][2], 'price' => $tableRows[13][3]?:0],
                    ['type' => '1', 'region' => '3', 'area' => $tableRows[14][1], 'sets' => $tableRows[14][2], 'price' => $tableRows[14][3]?:0],
                    ['type' => '1', 'region' => '4', 'area' => $tableRows[15][1], 'sets' => $tableRows[15][2], 'price' => $tableRows[15][3]?:0],
                ],
                2 => [
                    ['type' => '2', 'region' => '0', 'area' => $tableRows[17][1], 'sets' => $tableRows[17][2], 'price' => $tableRows[17][3]?:0],
                    ['type' => '2', 'region' => '1', 'area' => $tableRows[18][1], 'sets' => $tableRows[18][2], 'price' => $tableRows[18][3]?:0],
                    ['type' => '2', 'region' => '2', 'area' => $tableRows[19][1], 'sets' => $tableRows[19][2], 'price' => $tableRows[19][3]?:0],
                    ['type' => '2', 'region' => '3', 'area' => $tableRows[20][1], 'sets' => $tableRows[20][2], 'price' => $tableRows[20][3]?:0],
                    ['type' => '2', 'region' => '4', 'area' => $tableRows[21][1], 'sets' => $tableRows[21][2], 'price' => $tableRows[21][3]?:0],
                ],
                3 => [
                    ['type' => '3', 'region' => '0', 'area' => $tableRows[23][1], 'sets' => $tableRows[23][2], 'price' => $tableRows[23][3]?:0],
                    ['type' => '3', 'region' => '1', 'area' => $tableRows[24][1], 'sets' => $tableRows[24][2], 'price' => $tableRows[24][3]?:0],
                    ['type' => '3', 'region' => '2', 'area' => $tableRows[25][1], 'sets' => $tableRows[25][2], 'price' => $tableRows[25][3]?:0],
                    ['type' => '3', 'region' => '3', 'area' => $tableRows[26][1], 'sets' => $tableRows[26][2], 'price' => $tableRows[26][3]?:0],
                    ['type' => '3', 'region' => '4', 'area' => $tableRows[27][1], 'sets' => $tableRows[27][2], 'price' => $tableRows[27][3]?:0],
                ],
                4 => [
                    ['type' => '4', 'region' => '0', 'area' => $tableRows[29][1], 'sets' => $tableRows[29][2], 'price' => $tableRows[29][3]?:0],
                    ['type' => '4', 'region' => '1', 'area' => $tableRows[30][1], 'sets' => $tableRows[30][2], 'price' => $tableRows[30][3]?:0],
                    ['type' => '4', 'region' => '2', 'area' => $tableRows[31][1], 'sets' => $tableRows[31][2], 'price' => $tableRows[31][3]?:0],
                    ['type' => '4', 'region' => '3', 'area' => $tableRows[32][1], 'sets' => $tableRows[32][2], 'price' => $tableRows[32][3]?:0],
                    ['type' => '4', 'region' => '4', 'area' => $tableRows[33][1], 'sets' => $tableRows[33][2], 'price' => $tableRows[33][3]?:0],
                ],
            ];
            $res[0] = CrawlHslxfxData::query()->whereYear('created_at', date('Y'))->where('type', '0')->first();
            $res[1] = CrawlHslxfxData::query()->whereYear('created_at', date('Y'))->where('type', '1')->first();
            $res[2] = CrawlHslxfxData::query()->whereMonth('created_at', date('m'))->where('type', '2')->first();
            if (!$res[0] || date('m-d') == '12-31') {
                foreach ($data[0] as $val) {
                    CrawlHslxfxData::create($val);
                }
            }
            if (!$res[1] || date('m-d') == '12-31') {
                foreach ($data[1] as $val) {
                    CrawlHslxfxData::create($val);
                }
            }
            if (date('m-d',strtotime("last day of this month", time())) == date('m-d')) {
                foreach ($data[2] as $val) {
                    CrawlHslxfxData::create($val);
                }
            }
            // todo 不统计上月销售统计了，$res[3]默认是上月销售统计的
            // todo 不统计今日销售统计了，$res[4]默认是今日销售统计的


        } catch (\Exception $e) {
            \Log::error('sjhz_xsmj方法请求失败，终止此次请求');
            \Log::error($e);
            $ex = CrawlExceptionData::query()->whereDate('created_at', date('Y-m-d'))->where('cron_name', 'CrawlHslxfx')->first();
            if (!$ex) {
                CrawlExceptionData::create([
                    'cron_name' => 'CrawlHslxfx',
                    'cause' => $e->getMessage(),
                    'num' => 1
                ]);
                $this->hs_lxfx();
            } else {
                if ($ex->num <= 3) {
                    $ex->increment('num');
                    $this->hs_lxfx();
                } else {
                    die;
                }
            }
            die;
        }
    }
}
