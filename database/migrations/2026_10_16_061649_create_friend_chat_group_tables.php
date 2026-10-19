<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Permanent friend groups
        Schema::create('friend_chat_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('image')->nullable();
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // Group members
        Schema::create('friend_chat_group_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('group_id')
                ->constrained('friend_chat_groups')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->boolean('is_admin')->default(false);

            $table->timestamps();

            $table->unique(['group_id', 'user_id']);
        });

        // Permanent group messages
        Schema::create('friend_chat_group_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('group_id')
                ->constrained('friend_chat_groups')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('message')->nullable();

            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();
            $table->string('attachment_mime')->nullable();
            $table->unsignedBigInteger('attachment_size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friend_chat_group_messages');
        Schema::dropIfExists('friend_chat_group_members');
        Schema::dropIfExists('friend_chat_groups');
    }
};
