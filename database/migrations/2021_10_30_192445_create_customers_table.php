<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fiscal_id');
            $table->string('document_number')->nullable();
            $table->string('phones');
            $table->timestamps();

            $table->unique('fiscal_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}
