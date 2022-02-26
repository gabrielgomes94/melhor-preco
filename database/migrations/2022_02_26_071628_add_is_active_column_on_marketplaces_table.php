<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveColumnOnMarketplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marketplaces', function(Blueprint $table) {
            $table->float('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('marketplaces', 'is_active')) {
            Schema::table('marketplaces', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
}
