<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    public function up(): void
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('name');
            $table->float('quantity');
            $table->float('unit_value');
            $table->float('discount');
            $table->foreignId('sale_order_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_items');
    }
}
