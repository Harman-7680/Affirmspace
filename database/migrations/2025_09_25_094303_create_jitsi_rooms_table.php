<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jitsi_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_name')->unique();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->integer('max_users')->default(10);
            $table->string('jitsi_link')->nullable();
            $table->integer('duration_minutes')->default(30); // room duration
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jitsi_rooms');
    }
};
