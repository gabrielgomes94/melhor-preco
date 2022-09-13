<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidColumnOnSaleOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::table('sale_orders', function (Blueprint $table) {
            $table->uuid('uuid');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('sale_orders', 'uuid')) {
            Schema::table('sale_orders', function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
}
