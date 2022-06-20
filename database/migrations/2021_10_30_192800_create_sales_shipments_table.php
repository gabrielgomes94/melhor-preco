<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesShipmentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('sales_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('sale_order_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_shipments');
    }
}
