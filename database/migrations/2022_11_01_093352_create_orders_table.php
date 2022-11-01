<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // order number unique integer
            $table->string('order_number')->unique();
            // cashier name string
            $table->string('cashier_name');
            // waiter name string
            $table->string('waiter_name');
            // payment method string
            $table->string('payment_method');
            // total price decimal 20,2
            $table->decimal('total_price', 20, 2);
            // total quantity integer
            $table->integer('total_quantity');
            // status string
            $table->string('status');
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
};
