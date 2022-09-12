<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMarketplaceAndProductSkuColumnsFromPricesTable extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn('store');
            $table->dropColumn('marketplace_erp_id');
            $table->dropColumn('product_sku');
        });
    }

    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->string('product_sku')->nullable();
            $table->float('marketplace_erp_id')->nullable();
            $table->string('store')->default('');
        });
    }
}
