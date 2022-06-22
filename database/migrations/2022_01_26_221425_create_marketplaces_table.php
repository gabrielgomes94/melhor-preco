<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketplacesTable extends Migration
{
    public function up(): void
    {
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('erp_id');
            $table->string('erp_name');
            $table->string('name');
            $table->string('slug');
            $table->jsonb('extra');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplaces');
    }
}
