<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sale_order_id');
            $table->string('purchase_order_id');
            $table->string('integration')->nullable();
            $table->string('store_id')->nullable();
            $table->string('store_sale_order_id')->nullable();
            $table->timestamp('selled_at');
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('expected_arrival_at')->nullable();
            $table->float('discount')->default(0.0);
            $table->float('freight')->default(0.0);
            $table->string('status');
            $table->float('total_products');
            $table->float('total_value');
            $table->foreignId('customer_id');
            $table->timestamps();

            $table->unique('sale_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_orders');
    }
}
