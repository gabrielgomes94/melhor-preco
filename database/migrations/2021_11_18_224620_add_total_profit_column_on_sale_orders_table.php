<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalProfitColumnOnSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->decimal('total_profit', 12, 2)->nullable();
            $table->decimal('total_products', 12, 2)->change();
            $table->decimal('total_value', 12, 2)->change();
            $table->decimal('freight', 8, 2)->change();
            $table->decimal('discount', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
