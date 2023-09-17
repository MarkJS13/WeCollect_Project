<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('consumer_id');
            $table->unsignedBigInteger('collector_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('consumer_id')->references('id')->on('consumers');
            $table->foreign('collector_id')->references('id')->on('collectors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};
