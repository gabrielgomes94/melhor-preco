<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveColumnOnMarketplacesTable extends Migration
{
    public function up(): void
    {
        Schema::table('marketplaces', function(Blueprint $table) {
            $table->float('is_active')->default(true);
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('marketplaces', 'is_active')) {
            Schema::table('marketplaces', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
}
