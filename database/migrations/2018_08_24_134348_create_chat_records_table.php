<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('news_from')->default(0)->unsigned();
            $table->integer('news_to')->default(0)->unsigned();
            $table->longText('message');
            $table->string('type')->default('');
            $table->integer('created_at')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_records');
    }
}
