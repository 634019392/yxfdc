<?php

namespace App\Console\Commands\Cron;

use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:clean-excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理昨天excel保存的文件';

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
        $rm_dir = Carbon::yesterday()->format('Ymd');
        $path = public_path("/uploads/excel_images/$rm_dir");
        delDirAndFile($path);
    }
}
