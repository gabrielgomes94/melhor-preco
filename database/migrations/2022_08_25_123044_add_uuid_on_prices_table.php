<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidOnPricesTable extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->uuid('uuid');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('prices', 'uuid')) {
            Schema::table('prices', function (Blueprint $table) {
                $table->dropColumn('uuid');
            });
        }
    }
}
