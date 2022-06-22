<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSaleItemsSaleOrderIdColumnType extends Migration
{
    public function up(): void
    {
        Schema::table('sales_items', function (Blueprint $table) {
            $table->string('sale_order_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('sales_items', function (Blueprint $table) {
            $table->dropColumn('sale_order_id');
        });
    }
}
