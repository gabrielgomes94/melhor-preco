<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoresColumnToPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricing', function (Blueprint $table) {
            $table->json('stores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('pricing', 'stores')) {
            Schema::table('pricing', function (Blueprint $table) {
                $table->dropColumn('stores');
            });
        }
    }
}
