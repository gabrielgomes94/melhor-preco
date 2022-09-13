<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSaleOrderUuidColumnOnSalesShipmentsTable extends Migration
{
    public function up(): void
    {
        Schema::table('sales_shipments', function (Blueprint $table) {
            $table->foreignUuid('sale_order_uuid');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('sales_shipments', 'sale_order_uuid')) {
            Schema::table('sales_shipments', function (Blueprint $table) {
                $table->dropColumn('sale_order_uuid');
            });
        }
    }
}
