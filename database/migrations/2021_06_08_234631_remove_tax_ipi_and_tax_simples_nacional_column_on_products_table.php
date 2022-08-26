<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTaxIpiAndTaxSimplesNacionalColumnOnProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('tax_ipi');
            $table->dropColumn('tax_simples_nacional');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('tax_ipi', 7, 4)->default(0.0);
            $table->float('tax_simples_nacional', 7, 4)->default(0.0);
        });
    }
}
