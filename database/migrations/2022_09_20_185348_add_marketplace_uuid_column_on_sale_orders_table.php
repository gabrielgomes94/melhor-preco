<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarketplaceUuidColumnOnSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->foreignUuid('marketplace_uuid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasColumn('sale_orders', 'marketplace_uuid')) {
            Schema::table('sale_orders', function (Blueprint $table) {
                $table->dropColumn('marketplace_uuid');
            });
        }
    }
}
