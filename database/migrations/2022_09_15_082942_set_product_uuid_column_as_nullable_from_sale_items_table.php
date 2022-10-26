<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetProductUuidColumnAsNullableFromSaleItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('sales_items', function (Blueprint $table) {
            $table->foreignUuid('product_uuid')->change()->nullable();
        });

    }

    public function down(): void
    {
        if (Schema::hasColumn('sales_items', 'product_uuid')) {
            Schema::table('sales_items', function (Blueprint $table) {
                $table->dropColumn('product_uuid');
            });
        }
    }
}
