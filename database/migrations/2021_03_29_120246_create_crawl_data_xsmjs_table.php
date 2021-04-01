<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlDataXsmjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_data_xsmjs', function (Blueprint $table) {
            // http://119.100.21.219:81/Analysis_GuideRank.aspx 销售面积排行
            $table->bigIncrements('id');
            $table->enum('type', ['0', '1', '2', '3'])->default('0')->comment('类型:0其他，1今日销售面积、2本月销售面积、3今年销售面积');
            $table->integer('xsmj_num')->default(0)->comment('发布平台中的序号');
            $table->string('project_name', 20)->default('')->comment('项目名称');
            $table->string('region', 10)->default('阳新县')->comment('区域');
            $table->float('area', 10, 2)->default(0)->comment('面积');
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
        Schema::dropIfExists('crawl_data_xsmjs');
    }
}
