<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150)->default('')->comment('项目名称');
            $table->enum('is_marketing', ['0', '1'])->default('0')->comment('是否全民营销楼盘：0否1是');
            $table->string('address', 200)->default('')->comment('项目地址');
            $table->string('img', 255)->default('')->comment('项目封面图片');
            $table->string('phone', 15)->default('')->comment('售楼热线');
            $table->string('reference', 50)->default('')->comment('参考价格');
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
        Schema::dropIfExists('houses');
    }
}
