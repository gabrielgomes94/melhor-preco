<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->decimal('value', 8, 2);
            $table->decimal('profit', 8, 2);
            $table->string('store');
            $table->decimal('commission', 6, 4);

            $table->foreignId('product_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
}
