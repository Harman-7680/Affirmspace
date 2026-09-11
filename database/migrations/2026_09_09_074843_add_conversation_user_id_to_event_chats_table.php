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
        Schema::table('event_chats', function (Blueprint $table) {
            $table->unsignedBigInteger('conversation_user_id')
                ->nullable()
                ->after('sender_id');

            $table->foreign('conversation_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->index([
                'event_id',
                'conversation_user_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_chats', function (Blueprint $table) {
            $table->dropForeign([
                'conversation_user_id',
            ]);

            $table->dropIndex([
                'event_id',
                'conversation_user_id',
            ]);

            $table->dropColumn('conversation_user_id');
        });
    }
};
