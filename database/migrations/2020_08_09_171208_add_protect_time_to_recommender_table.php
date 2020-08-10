<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProtectTimeToRecommenderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recommenders', function (Blueprint $table) {
            $table->timestamp('protect_time')->nullable()->comment('保护时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recommenders', function (Blueprint $table) {
            $table->dropColumn('protect_time');
        });
    }
}
