<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostsPurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs_purchase_invoices', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('series');
            $table->string('number');
            $table->string('access_key');
            $table->string('xml');
            $table->string('link_danfe');
            $table->string('fiscal_id');
            $table->string('contact_name');
            $table->decimal('value');
            $table->dateTime('issued_at');
            $table->string('situation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costs_purchase_invoices');
    }
}
