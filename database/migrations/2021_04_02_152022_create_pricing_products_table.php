<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('pricing_id')->constrained('pricing');
            $table->foreignId('product_id')->constrained('products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_products');
    }
}
