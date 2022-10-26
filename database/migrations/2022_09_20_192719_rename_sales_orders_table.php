<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSalesOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::rename('sale_orders', 'sales_orders');
    }

    public function down(): void
    {
        Schema::rename('sales_orders', 'sale_orders');
    }
}
