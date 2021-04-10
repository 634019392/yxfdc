<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlExceptionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_exception_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cron_name', 20)->default('')->comment('爬取异常的命令方法');
            $table->text('cause')->comment('异常原因');
            $table->integer('num')->default(0)->comment('异常次数');
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
        Schema::dropIfExists('crawl_exception_data');
    }
}
