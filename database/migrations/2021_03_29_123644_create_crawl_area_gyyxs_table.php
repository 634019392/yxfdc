<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlAreaGyyxsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_area_gyyxs', function (Blueprint $table) {
            // http://119.100.21.219:81/Analysis_Area.aspx 区域分析->供应与销售统计
            $table->bigIncrements('id');
            $table->float('supply_area', 10, 2)->default(0)->comment('供应面积');
            $table->integer('supply_sets')->default(0)->comment('供应套数');
            $table->float('cjjj_price')->default(0)->comment('成交均价（元/㎡）');
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
        Schema::dropIfExists('crawl_area_gyyxs');
    }
}
