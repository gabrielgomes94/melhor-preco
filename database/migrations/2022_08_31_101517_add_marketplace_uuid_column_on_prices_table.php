<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarketplaceUuidColumnOnPricesTable extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->foreignUuid('marketplace_uuid');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('prices', 'marketplace_uuid')) {
            Schema::table('prices', function (Blueprint $table) {
                $table->dropColumn('marketplace_uuid');
            });
        }
    }
}
