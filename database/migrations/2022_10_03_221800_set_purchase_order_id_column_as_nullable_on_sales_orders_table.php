<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetPurchaseOrderIdColumnAsNullableOnSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn('purchase_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('sales_orders', 'purchase_order_id')) {
            Schema::table('sales_orders', function (Blueprint $table) {
                $table->string('purchase_order_id');
            });
        }
    }
}
