<?php

namespace App\Console\Commands\Cron;

use App\Models\Recommender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CustomerFailure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:customer-failure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '推荐客户超过保护期更改为失效状态';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Recommender::query()->where('status', '<=', '2')
            ->chunkById(1000, function ($item) {
                print_r($item->toArray());
                foreach($item as $val) {
                    $now = Carbon::now();
                    $protect_time = Carbon::parse($val->protect_time);
                    $diff = $now->diffInDays($protect_time, false);
                    if ($diff <= 0) {
                        $val->status = '5';
                        $val->save();
                        $this->info('更新成功的id:' . $val->id . ';状态更改为' . $val->status);
                    }
                }
            });
    }
}
