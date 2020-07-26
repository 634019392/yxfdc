<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phone',15)->default('')->index()->comment('手机');
            $table->string('card_alert_six',6)->default('')->comment('身份后六位数');
            $table->enum('sex',['男','女'])->default('男')->comment('性别');
            $table->unsignedTinyInteger('age')->default(0)->comment('年龄');
            $table->string('truename',20)->default('')->comment('真实姓名');
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
        Schema::dropIfExists('buyers');
    }
}
