<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelAssignTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_assgins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->date('datetime')->nullable();  // 进粉时间
            $table->string('wechat')->nullable();
            $table->string('company',50)->nullable();
            $table->string('details')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->string('type',20)->nullable();
            $table->integer('score')->nullable();
            $table->text('mark')->nullable();
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
        Schema::dropIfExists('channel_assgins');
    }
}
