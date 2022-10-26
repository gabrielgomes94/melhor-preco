<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSalesInvoicesTable extends Migration
{
    public function up(): void
    {
        Schema::rename('sales_invoice', 'sales_invoices');
    }

    public function down(): void
    {
        Schema::rename('sales_invoices', 'sales_invoice');
    }
}
