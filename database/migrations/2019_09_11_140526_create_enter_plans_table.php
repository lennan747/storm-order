<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enter_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('enter_time')->nullable();
            $table->string('a1')->nullable();
            $table->string('a2')->nullable();
            $table->string('a3')->nullable();;
            $table->string('a4')->nullable();
            $table->string('a5')->nullable();
            $table->string('a6')->nullable();
            $table->string('a7')->nullable();
            $table->string('a8')->nullable();
            $table->string('a9')->nullable();
            $table->string('a10')->nullable();
            $table->string('a11')->nullable();
            $table->string('a12')->nullable();
            $table->string('a13')->nullable();
            $table->string('a14')->nullable();
            $table->string('a15')->nullable();
            $table->string('a16')->nullable();
            $table->string('a17')->nullable();
            $table->string('a18')->nullable();
            $table->string('a19')->nullable();
            $table->string('a20')->nullable();
            $table->string('a21')->nullable();
            $table->string('a22')->nullable();
            $table->string('a23')->nullable();
            $table->string('a24')->nullable();
            $table->string('a25')->nullable();
            $table->string('a26')->nullable();
            $table->string('a27')->nullable();
            $table->string('a28')->nullable();
            $table->string('a29')->nullable();
            $table->string('a30')->nullable();
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
        Schema::dropIfExists('enter_plans');
    }
}
