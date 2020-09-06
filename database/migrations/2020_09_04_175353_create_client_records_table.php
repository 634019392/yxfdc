<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_records', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('recommender_id')->comment('关联的recommenders的id');
            $table->foreign('recommender_id')->references('id')->on('recommenders')->onDelete('cascade');

            $table->text('text')->nullable()->comment('时间+标题');
            $table->text('desc')->nullable()->comment('追踪客户描述');
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
        Schema::dropIfExists('client_records');
    }
}
