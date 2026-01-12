<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Link device to user
            $table->string('device_token')->nullable()->unique();             // FCM/APNS token
            $table->string('device_type')->nullable();                        // android / ios / web
            $table->string('device_name')->nullable();                        // optional: "iPhone 14", "Samsung S21"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
