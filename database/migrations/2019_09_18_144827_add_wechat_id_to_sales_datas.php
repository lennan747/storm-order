<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWechatIdToSalesDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_datas', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('wechat_id')->after('user_id')->nullable();
            $table->foreign('wechat_id')->references('id')->on('wechat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_datas', function (Blueprint $table) {
            //
            $table->dropColumn('wechat');
        });
    }
}
