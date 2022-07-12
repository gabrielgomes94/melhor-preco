<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFreightColumnOnMarketplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marketplaces', function (Blueprint $table) {
            $table->jsonb('freight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('marketplaces', 'freight')) {
            Schema::table('marketplaces', function (Blueprint $table) {
                $table->dropColumn('freight');
            });
        }
    }
}
