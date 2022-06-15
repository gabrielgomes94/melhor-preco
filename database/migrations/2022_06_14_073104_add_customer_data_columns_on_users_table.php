<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerDataColumnsOnUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('erp_token')->nullable();
            $table->string('erp')->nullable();
            $table->string('phone');
            $table->string('fiscal_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('erp');
            $table->dropColumn('erp_token');
            $table->dropColumn('phone');
            $table->dropColumn('fiscal_id');
        });
    }
}
