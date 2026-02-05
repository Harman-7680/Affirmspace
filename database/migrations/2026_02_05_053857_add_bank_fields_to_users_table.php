<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('razorpay_account_id')->nullable()->after('price');
            $table->enum('bank_status', ['not_added', 'pending', 'verified', 'rejected'])
                ->default('not_added')
                ->after('razorpay_account_id');
            $table->string('bank_rejection_reason')->nullable()->after('bank_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
