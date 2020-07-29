<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseIntroducesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_introduces', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('house_id')->comment('关联的楼盘id');
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

            $table->timestamp('open_time')->default('1999-01-01 23:59:59')->comment('开盘日期');
            $table->text('feature')->default('')->comment('楼盘特色');
            $table->string('type', 20)->default('')->comment('产品类型:高层，洋房，别墅，公寓');
            $table->string('decor', 250)->default('')->comment('装修情况:带装修,毛坯');
            $table->integer('floor_space')->default(1)->comment('占地面积');
            $table->tinyInteger('property_right')->default(70)->comment('产权:例50年');
            $table->tinyInteger('greening')->default(20)->comment('绿化率');
            $table->tinyInteger('plot')->default(20)->comment('容积率');
            $table->string('property_name', 20)->nullable()->comment('物业名称');
            $table->timestamp('delivery_time')->nullable()->comment('交付日期');

            $table->string('traffic', 250)->nullable()->comment('交通配套介绍');
            $table->string('education', 250)->nullable()->comment('教育配套介绍');
            $table->string('medical', 250)->nullable()->comment('医疗配套介绍');
            $table->string('business', 250)->nullable()->comment('商业配套介绍');
            $table->string('other' , 250)->nullable()->comment('其他配套介绍');
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
        Schema::dropIfExists('house_introduces');
    }
}
