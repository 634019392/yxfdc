<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSkipPageToAdvimgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advimgs', function (Blueprint $table) {
            $table->string('skip_page', 255)->nullable()->comment('小程序跳转页面地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advimgs', function (Blueprint $table) {
            $table->dropColumn('skip_page');
        });
    }
}
