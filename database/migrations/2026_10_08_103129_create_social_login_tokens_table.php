<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_login_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('provider'); // google / facebook
            $table->string('social_id');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->text('avatar')->nullable();
            $table->timestamps();

            $table->index(['provider', 'social_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_login_tokens');
    }
};
