<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            // 存储微博内容
            $table->text('content');
            // 第二个字段为 integer 类型的 user_id 字段，用于储存微博发布者的个人 id，后面我们会借助 user_id 来查找指定用户发布过的所有微博，因此为了提高查询效率，这里我们需要为该字段加上索引
            $table->integer('user_id')->index();
            // 为微博的创建时间添加index索引，为微博的创建时间添加索引的目的是，后面我们会根据微博的创建时间进行倒序输出，并在页面上进行显示，使新建的微博能够排在比较靠前的位置。
            $table->index(['created_at']);
            // 生成创建时间，和更新时间
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
        Schema::dropIfExists('statuses');
    }
}
