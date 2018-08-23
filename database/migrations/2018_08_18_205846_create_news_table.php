<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('send_by')->unsigned()->comment('发送者id');
            $table->integer('send_to')->unsigned()->comment('接收者id');
            $table->string('content')->comment('消息内容');
            $table->enum('status', [0, 1])->comment('状态:0未读，1已读');
            $table->integer('created_at')->unsigned()->comment('消息发送时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
