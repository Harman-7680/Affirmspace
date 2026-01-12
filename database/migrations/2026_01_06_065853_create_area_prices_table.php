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
        // database/migrations/xxxx_create_area_prices_table.php
        Schema::create('area_prices', function (Blueprint $table) {
            $table->id();
            $table->string('area_range'); // 100m, 500m, 1km
            $table->integer('amount');    // 50, 100, 500
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_prices');
    }
};
