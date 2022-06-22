<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function(Blueprint $table) {
            $table->uuid('uuid');
            $table->string('category_id');
            $table->string('parent_category_id');
            $table->string('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}
