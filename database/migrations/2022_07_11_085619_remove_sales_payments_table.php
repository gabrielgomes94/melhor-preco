<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSalesPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sales_payments');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('sales_payments', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->timestamp('expires_at');
            $table->text('observation')->nullable();
            $table->string('destination')->nullable();
            $table->foreignId('sale_order_id');
            $table->timestamps();
        });
    }
}
