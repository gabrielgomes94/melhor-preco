<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCommissionColumnOnMarketplacesTable extends Migration
{
    public function up(): void
    {
        Schema::table('marketplaces', function (Blueprint $table) {
            $table->renameColumn('extra', 'commission');
        });
    }

    public function down(): void
    {
        Schema::table('marketplaces', function (Blueprint $table) {
            $table->renameColumn('commission', 'extra');
        });
    }
}
