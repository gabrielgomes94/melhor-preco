<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPricingTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('pricing_products');
        Schema::dropIfExists('pricing');
    }

    public function down(): void
    {
        Schema::create('pricing', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('pricing_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

//            $table->foreignId('pricing_id')->constrained('pricing');
//            $table->foreignId('product_id')->constrained('products');
        });
    }
}
