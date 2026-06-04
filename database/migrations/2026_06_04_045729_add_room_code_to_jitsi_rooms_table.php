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
        Schema::table('jitsi_rooms', function (Blueprint $table) {

            $table->string('room_code')
                ->nullable()
                ->after('room_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jitsi_rooms', function (Blueprint $table) {

            $table->dropColumn('room_code');
        });
    }
};
