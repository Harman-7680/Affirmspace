<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jitsi_room_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jitsi_room_id')->constrained('jitsi_rooms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();

            $table->unique(['jitsi_room_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jitsi_room_user');
    }
};
