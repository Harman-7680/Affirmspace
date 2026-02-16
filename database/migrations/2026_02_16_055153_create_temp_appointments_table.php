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
        Schema::create('temp_appointments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');

            $table->string('subject');
            $table->string('email');
            $table->text('message_body');

            $table->unsignedBigInteger('availability_id');

            $table->string('razorpay_order_id')->unique();
            $table->string('razorpay_payment_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_appointments');
    }
};
