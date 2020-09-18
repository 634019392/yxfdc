<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('act_params', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('house_id')->comment('关联的楼盘id');
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

            $table->boolean('is_check')->default(false)->comment('是否审核');
            $table->integer('check_day')->default(0)->comment('审核天数');

            $table->string('fee_text', 100)->default('')->comment('推荐费文字说明');
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
        Schema::dropIfExists('act_params');
    }
}
