<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProductIdColumnOnPricesTable extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('prices', 'product_id')) {
            Schema::table('prices', function (Blueprint $table) {
                $table->bigInteger('product_id');
            });
        }
    }
}
