<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsPurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs_purchase_items', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('product_sku')->nullable();
            $table->string('product_uuid')->nullable();
            $table->string('name');
            $table->decimal('unit_cost');
            $table->decimal('unit_price');
            $table->decimal('taxes_cost')->default(0.0);
            $table->decimal('freight_cost')->default(0.0);
            $table->decimal('insurance_cost')->default(0.0);
            $table->float('quantity')->default(1.0);
            $table->foreignUuid('purchase_invoice_uuid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costs_purchase_items');
    }
}
