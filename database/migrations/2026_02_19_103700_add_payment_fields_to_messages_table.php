<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (! Schema::hasColumn('messages', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid'])
                    ->default('pending');
            }

            if (! Schema::hasColumn('messages', 'razorpay_payment_id')) {
                $table->string('razorpay_payment_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'razorpay_payment_id',
            ]);
        });
    }
};
