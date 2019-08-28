<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('fans_name',50)->nullable();
            $table->date('datetime')->nullable();  // 进粉时间
            $table->string('payment_method',15)->nullable();  // 支付方式
            $table->string('phone_number',15)->nullable();

            $table->string('no',120)->unique();
            $table->decimal('prepayments',10, 2); // 预付款
            $table->decimal('total_amount', 10, 2);
            $table->text('address');
            $table->string('ship_status',20)->default(\App\Models\Order::SHIP_STATUS_PENDING);
            $table->text('ship_data')->nullable();
//            $table->text('extra')->nullable();
            $table->boolean('closed')->default(false);
            $table->boolean('reviewed')->default(false);
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
