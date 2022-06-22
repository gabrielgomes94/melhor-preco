<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnitCostColumnFromCostsPurchaseItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('costs_purchase_items', function (Blueprint $table) {
            $table->dropColumn('unit_cost');
        });
    }

    public function down(): void
    {
        Schema::table('costs_purchase_items', function (Blueprint $table) {
            $table->decimal('unit_cost');
        });
    }
}
