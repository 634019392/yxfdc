<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlQsfxDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_qsfx_data', function (Blueprint $table) {
            // http://119.100.21.219:81/Analysis_Saled.aspx 趋势分析中数据统计
            $table->bigIncrements('id');
            $table->enum('type', ['0','1','2','3','4'])->default('0')->comment('类型：0其他，1销售面积分析，2销售套数分析，3供应面积分析，4供应套数分析');
            $table->float('jan', 10, 2)->default(0)->comment('1月');
            $table->float('feb', 10, 2)->default(0)->comment('2月');
            $table->float('mar', 10, 2)->default(0)->comment('3月');
            $table->float('apr', 10, 2)->default(0)->comment('4月');
            $table->float('may', 10, 2)->default(0)->comment('5月');
            $table->float('jun', 10, 2)->default(0)->comment('6月');
            $table->float('jul', 10, 2)->default(0)->comment('7月');
            $table->float('aug', 10, 2)->default(0)->comment('8月');
            $table->float('sep', 10, 2)->default(0)->comment('9月');
            $table->float('oct', 10, 2)->default(0)->comment('10月');
            $table->float('nov', 10, 2)->default(0)->comment('11月');
            $table->float('dec', 10, 2)->default(0)->comment('12月');
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
        Schema::dropIfExists('crawl_qsfx_data');
    }
}
