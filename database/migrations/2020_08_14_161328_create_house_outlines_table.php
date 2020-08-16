<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseOutlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_outlines', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('house_id')->comment('关联的楼盘id');
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

            $table->string('outline_pic', 255)->nullable()->comment('项目简介图片');

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
        Schema::dropIfExists('house_outlines');
    }
}
