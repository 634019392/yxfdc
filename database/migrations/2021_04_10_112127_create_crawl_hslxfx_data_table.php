<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlHslxfxDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_hslxfx_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['0','1','2','3','4'])->default('0')->comment('类型：0供应与销售统计，1今年销售统计，2本月销售统计，3上月销售统计，4今日销售统计');
            $table->enum('region', ['0','1','2','3','4'])->default('0')->comment('区域：0全市，1黄石港区，2西塞山区，3下陆区，4开发区·铁山区');
            $table->float('area',10, 2)->default(0)->comment('面积');
            $table->float('sets',10, 2)->default(0)->comment('套数');
            $table->float('price',10, 2)->default(0)->comment('均价');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crawl_hslxfx_data');
    }
}
