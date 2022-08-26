<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductUuidOnPricesTable extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->foreignUuid('product_uuid');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('prices', 'product_uuid')) {
            Schema::table('prices', function (Blueprint $table) {
                $table->dropColumn('product_uuid');
            });
        }
    }
}
