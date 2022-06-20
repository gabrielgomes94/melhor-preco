<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockColumnOnProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function(Blueprint $table) {
            $table->float('quantity')->nullable();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('quantity');
            });
        }
    }
}
