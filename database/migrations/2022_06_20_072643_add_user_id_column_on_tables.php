<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdColumnOnTables extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('costs_purchase_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('marketplaces', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('prices', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('sale_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
//        Schema::table('categories', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
//
//        Schema::table('costs_purchase_invoices', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
//
//        Schema::table('marketplaces', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
//
//        Schema::table('prices', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
//
//        Schema::table('products', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
//
//        Schema::table('promotions', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
//
//        Schema::table('sale_orders', function (Blueprint $table) {
//            $table->dropColumn('user_id');
//        });
    }
}