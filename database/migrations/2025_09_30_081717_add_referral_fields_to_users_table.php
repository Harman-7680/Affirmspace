<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Make nullable first to avoid unique constraint errors on existing rows
            $table->string('refer_code')->nullable()->after('email');
            $table->string('referred_by')->nullable()->after('refer_code');
        });

        // Optional: Populate refer_code for existing users with unique values
        // You can run this in tinker or here if you want:

        \App\Models\User::all()->each(function ($user) {
            if (! $user->refer_code) {
                $user->refer_code = strtolower($user->first_name) . '_' . rand(1000, 9999);
                $user->save();
            }
        });

        // Now add unique constraint safely (after ensuring all existing values are unique)
        Schema::table('users', function (Blueprint $table) {
            $table->unique('refer_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['refer_code']);
            $table->dropColumn(['refer_code', 'referred_by']);
        });
    }
};
