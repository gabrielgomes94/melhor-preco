<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressesColumnsForSalesShipmentsTable extends Migration
{
    public function up(): void
    {
        Schema::table('sales_shipments', function (Blueprint $table) {
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('district')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
        });
    }

    public function down(): void
    {
        Schema::table('sales_shipments', function (Blueprint $table) {
            $table->dropColumn('street');
            $table->dropColumn('number');
            $table->dropColumn('complement');
            $table->dropColumn('district');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zipcode');
        });
    }
}
