<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarkToSalesDatas extends Migration
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
            $table->text('mark')->nullable()->after('transaction_number');
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
            $table->dropColumn('mark');
        });
    }
}
