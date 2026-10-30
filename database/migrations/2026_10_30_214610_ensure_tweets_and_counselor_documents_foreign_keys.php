<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tweets: user_id -> users.id
        if (Schema::hasTable('tweets') && Schema::hasColumn('tweets', 'user_id')) {
            $exists = DB::table('information_schema.KEY_COLUMN_USAGE')
                ->where('TABLE_SCHEMA', DB::getDatabaseName())
                ->where('TABLE_NAME', 'tweets')
                ->where('COLUMN_NAME', 'user_id')
                ->where('REFERENCED_TABLE_NAME', 'users')
                ->exists();

            if (! $exists) {
                Schema::table('tweets', function (Blueprint $table) {
                    $table->foreign('user_id', 'tweets_user_id_foreign')
                        ->references('id')
                        ->on('users')
                        ->cascadeOnDelete();
                });
            }
        }

        // Counselor documents: user_id -> users.id
        if (Schema::hasTable('counselor_documents') && Schema::hasColumn('counselor_documents', 'user_id')) {
            $exists = DB::table('information_schema.KEY_COLUMN_USAGE')
                ->where('TABLE_SCHEMA', DB::getDatabaseName())
                ->where('TABLE_NAME', 'counselor_documents')
                ->where('COLUMN_NAME', 'user_id')
                ->where('REFERENCED_TABLE_NAME', 'users')
                ->exists();

            if (! $exists) {
                Schema::table('counselor_documents', function (Blueprint $table) {
                    $table->foreign('user_id', 'counselor_documents_user_id_foreign')
                        ->references('id')
                        ->on('users')
                        ->cascadeOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        // Intentionally empty.
        // These foreign keys already existed in the databases before this
        // migration was created. Rolling back must not remove existing constraints.
    }
};