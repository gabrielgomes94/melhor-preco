<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEanColumnOnCostsPurchaseItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('costs_purchase_items', function (Blueprint $table) {
            $table->string('ean')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('costs_purchase_items', function (Blueprint $table) {
            $table->dropColumn('ean');
        });
    }
}
