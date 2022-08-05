<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('promotions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('name');
            $table->json('products');
            $table->decimal('discount');
            $table->decimal('marketplace_subsidy');
            $table->integer('max_products_limit');
            $table->dateTime('begin_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }
}
