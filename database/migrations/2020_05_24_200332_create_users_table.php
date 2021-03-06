<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 后台用户表
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('role_id')->default(0)->comment('角色id');

            $table->string('username', 30)->comment('用户名');
            $table->string('truename', 30)->default('未知')->comment('真实姓名');
            $table->string('password', 255)->comment('密码');
            $table->string('email', 50)->default('')->comment('邮箱');
            $table->string('phone', 15)->default('')->comment('手机号码');
            $table->enum('sex', ['先生', '女士'])->default('先生')->comment('性别');
            $table->char('last_id', 15)->default('')->comment('登录IP');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
