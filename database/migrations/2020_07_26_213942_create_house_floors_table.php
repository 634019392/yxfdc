<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseFloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_floors', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('house_id')->comment('关联的楼盘id');
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

            $table->string('floor_plan', 255)->nullable()->comment('户型图');
            $table->string('floor_row1', 255)->nullable()->comment('描述1，例如：尊享四室两厅一卫');
            $table->string('floor_row2', 255)->nullable()->comment('描述2，例如：户型：C1户型');
            $table->string('floor_row3', 255)->nullable()->comment('描述3，例如：面积：约140㎡');

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
        Schema::dropIfExists('house_floors');
    }
}
