<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSkuColumnsOnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sku_magalu');
            $table->dropColumn('sku_b2w');
            $table->dropColumn('sku_mercado_livre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku_magalu')->nullable();
            $table->string('sku_b2w')->nullable();
            $table->string('sku_mercado_livre')->nullable();
        });
    }
}
