<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPriceCampaignsTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('price_campaigns');
    }

    public function down(): void
    {
        Schema::create('price_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('products');
            $table->json('stores');
            $table->timestamps();
        });
    }
}
