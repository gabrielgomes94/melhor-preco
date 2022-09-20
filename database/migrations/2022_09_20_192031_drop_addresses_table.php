<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAddressesTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('addresses');
    }

    public function down(): void
    {
        if (!Schema::hasTable('addresses')) {
            Schema::create('addresses', function (Blueprint $table) {
                $table->id();

                $table->string('street');
                $table->string('number');
                $table->string('complement')->nullable();
                $table->string('district');
                $table->string('city');
                $table->string('state');
                $table->string('zipcode');
                $table->morphs('addressable');

                $table->timestamps();
            });
        }
    }
}
