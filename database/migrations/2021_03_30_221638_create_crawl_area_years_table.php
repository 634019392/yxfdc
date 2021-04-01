<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlAreaYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_area_years', function (Blueprint $table) {
            // http://119.100.21.219:81/Analysis_Area.aspx 区域分析->今年销售统计
            $table->bigIncrements('id');
            $table->float('area', 11, 2)->default(0)->comment('销售面积(㎡)');
            $table->integer('sets')->default(0)->comment('销售套数');
            $table->float('price', 10, 2)->default(0)->comment('销售均价(元/㎡)');
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
        Schema::dropIfExists('crawl_area_years');
    }
}
