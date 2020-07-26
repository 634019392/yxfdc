<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apiusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            // 规定一天只能请求2000次
            $table->unsignedInteger('click')->default(0)->comment('短信请求次数');
            $table->string('openid',50)->default('')->index()->comment('小程序ID号');
            $table->string('session_id',200)->default('')->comment('sessionKey经过base64加密后的数据');
            $table->string('nickname',50)->default('')->comment('昵称');
            $table->string('phone',15)->default('')->comment('手机');
            // 手机号通过发短信验证码来验证
            $table->string('phone_node', 100)->default('')->comment('手机短信验证码,格式：验证码#发送的时间');
            $table->enum('is_phone_auth',['0','1'])->default('0')->comment('代表经纪人手机号是否认证：0否，1是');
            $table->string('card_alert_six',6)->default('')->comment('身份后六位数');
            $table->enum('sex',['男','女'])->default('男')->comment('性别');
            $table->unsignedTinyInteger('age')->default(0)->comment('年龄');
            $table->string('avatar',200)->default('')->comment('头像');
            $table->string('truename',20)->default('')->comment('真实姓名');
            $table->string('id_card',18)->default('')->index()->comment('认证经纪人必填身份证号');
            $table->string('id_card_img',255)->default('')->comment('认证经纪人必填身份证照片');
            $table->enum('is_principal',['0','1'])->default('0')->comment('是否是楼盘负责人：0否，1是');
            $table->unsignedBigInteger('main_house_id')->default(0)->comment('负责人所负责楼盘id,默认为0没有');
            $table->enum('is_property_consultant',['0','1'])->default('0')->comment('是否是置业顾问：0否，1是');
            $table->unsignedBigInteger('minor_house_id')->default(0)->comment('置业顾问所在楼盘id,默认为0没有');
            $table->string('api_token',2000)->default('')->comment('passport提供的个人访问令牌');
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
        Schema::dropIfExists('apiusers');
    }
}
