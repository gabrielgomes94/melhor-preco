<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdOnProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function(Blueprint $table) {
            $table->string('category_id')->nullable();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('category_id');
            });
        }
    }
}
