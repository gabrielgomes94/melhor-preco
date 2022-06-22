<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarketplaceErpIdColumnOnPricesTable extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function(Blueprint $table) {
            $table->float('marketplace_erp_id')->nullable();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('prices', 'marketplace_erp_id')) {
            Schema::table('prices', function (Blueprint $table) {
                $table->dropColumn('marketplace_erp_id');
            });
        }
    }
}
