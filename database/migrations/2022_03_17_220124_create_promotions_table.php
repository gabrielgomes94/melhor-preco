<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('name');
            $table->json('products');
            $table->decimal('discount');
            $table->decimal('marketplace_subsidy');
            $table->integer('max_products_limit');
            $table->dateTime('begin_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
}
