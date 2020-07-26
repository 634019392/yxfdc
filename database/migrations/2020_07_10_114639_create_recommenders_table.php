<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommenders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('apiuser_id')->default(0)->index()->comment('推荐人id');
            $table->integer('buyer_id')->default(0)->index()->comment('购买者id');
            $table->integer('house_id')->default(0)->index()->comment('给购买者推荐的楼盘id');
            $table->enum('status', ['1', '2', '3', '4', '5'])->default('1')->comment('1：未到访，2：已到访，3：已认购，4：已签约，5：已过期');
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
        Schema::dropIfExists('recommenders');
    }
}

