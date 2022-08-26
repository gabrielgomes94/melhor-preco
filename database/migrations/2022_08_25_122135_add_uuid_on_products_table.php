<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidOnProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->uuid('uuid');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'uuid')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
}
