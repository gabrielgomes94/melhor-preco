<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesInPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices_in_promotions', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->foreignId('price_id');
            $table->foreignUuid('promotion_uuid');
            $table->decimal('value');
            $table->decimal('profit');
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
        Schema::dropIfExists('prices_in_promotions');
    }
}
