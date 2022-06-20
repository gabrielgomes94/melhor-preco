<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceTable extends Migration
{
    public function up(): void
    {
        Schema::create('sales_invoice', function (Blueprint $table) {
            $table->id();
            $table->string('series');
            $table->string('number');
            $table->timestamp('issued_at');
            $table->string('status');
            $table->float('value');
            $table->string('access_key');
            $table->foreignId('sale_order_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_invoice');
    }
}
