<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatToChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_to_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('wechat_id');
            $table->integer('channel_id')->nullable();
            //$table->integer('plan_id');
            $table->date('datetime');
            $table->text('mark')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_to_channels');
    }
}
