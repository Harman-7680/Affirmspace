<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutedUsersTable extends Migration
{
    public function up()
    {
        Schema::create('muted_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');       // who mutes
            $table->foreignId('muted_user_id')->constrained('users')->onDelete('cascade'); // who is muted
            $table->timestamps();

            $table->unique(['user_id', 'muted_user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('muted_users');
    }
}
