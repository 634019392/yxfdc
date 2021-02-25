<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['1', '2'])->default('1')->comment('1:使用内部链接，2:微信公众号永久素材');
            $table->text('url')->comment('此为本地程序生成链接');
            $table->string('title', 100)->default('')->comment('标题');
            $table->string('author', 100)->default('')->comment('作者');
            $table->text('cover_img')->comment('封面图,微信图片字段为thumb_url');
            $table->string('digest')->default('')->comment('摘要');
            $table->longText('content')->comment('内容');
            $table->string('thumb_media_id')->default('')->comment('微信公众号永久素材 图文消息的封面图片素材id（必须是永久mediaID）');
            $table->string('thumb_url')->default('')->comment('微信公众号永久素材 封面图');
            $table->string('show_cover_pic', 1)->default('')->comment('微信公众号永久素材 是否显示封面，0为false，即不显示，1为true，即显示');
            $table->string('media_id', 100)->default('')->index()->comment('微信公众号永久素材 id');
            $table->longText('wechat_url')->comment('微信公众号永久素材 图文页的URL');
            $table->longText('content_source_url')->comment('微信公众号 点击“阅读原文”后的URL');
            $table->boolean('is_gather')->default(false)->comment('微信公众号永久素材 是否允许采集');
            $table->bigInteger('wechat_create_time')->nullable()->comment('微信公众号永久素材 创建时间(时间戳格式)');
            $table->bigInteger('wechat_update_time')->nullable()->comment('微信公众号永久素材 更新时间(时间戳格式)');
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
        Schema::dropIfExists('boards');
    }
}
