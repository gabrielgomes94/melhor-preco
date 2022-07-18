<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarginColumnOnPricesDatabase extends Migration
{
    public function up(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->decimal('margin')->default(0.0);
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('prices', 'margin')) {
            Schema::table('prices', function (Blueprint $table) {
                $table->dropColumn('margin');
            });
        }
    }
}
