<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlDataXstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_data_xsts', function (Blueprint $table) {
            // http://119.100.21.219:81/Analysis_GuideRank.aspx 销售套数排行
            $table->bigIncrements('id');
            $table->enum('type', ['0', '1', '2', '3'])->default('0')->comment('类型:0其他，1今日销售套数、2本月销售套数、3今年销售套数');
            $table->integer('xsts_num')->default(0)->comment('发布平台中的序号');
            $table->string('project_name', 20)->default('')->comment('项目名称');
            $table->string('region', 10)->default('')->comment('区域');
            $table->integer('sets')->default(0)->comment('套数');
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
        Schema::dropIfExists('crawl_data_xsts');
    }
}
