<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('counselor_availabilities', function (Blueprint $table) {
            // Add new columns
            $table->time('start_time')->after('available_date');
            $table->time('end_time')->after('start_time');

            // Optional: Remove old column if no longer needed
            $table->dropColumn('available_time');
        });
    }

    public function down()
    {
        Schema::table('counselor_availabilities', function (Blueprint $table) {
            // Restore old column if rolled back
            $table->time('available_time')->nullable();

            // Remove the new columns
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
};
