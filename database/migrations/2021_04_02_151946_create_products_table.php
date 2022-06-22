<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('sku');
            $table->string('name');
            $table->decimal('purchase_price', 8, 2);
            $table->string('sku_magalu')->nullable();
            $table->string('sku_b2w')->nullable();
            $table->string('sku_mercado_livre')->nullable();
            $table->float('tax_ipi', 7, 4);
            $table->float('tax_icms', 7, 4);
            $table->float('tax_simples_nacional', 7, 4);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
