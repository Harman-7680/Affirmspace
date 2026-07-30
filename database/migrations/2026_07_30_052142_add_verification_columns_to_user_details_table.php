<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_details', function (Blueprint $table) {

            $table->enum('verification_method', ['selfie', 'id'])
                ->nullable()
                ->after('verification_status');

            $table->string('verification_selfie')
                ->nullable()
                ->after('verification_method');

            $table->string('verification_id')
                ->nullable()
                ->after('verification_selfie');

            $table->timestamp('verified_at')
                ->nullable()
                ->after('verification_id');

            $table->unsignedBigInteger('verified_by')
                ->nullable()
                ->after('verified_at');

            $table->text('rejection_reason')
                ->nullable()
                ->after('verified_by');
        });
    }

    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {

            $table->dropColumn([
                'verification_method',
                'verification_selfie',
                'verification_id',
                'verified_at',
                'verified_by',
                'rejection_reason',
            ]);

        });
    }
};
