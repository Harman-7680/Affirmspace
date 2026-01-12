<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('UserStatus')->default(0)->after('role');
            // You can change 'after' to the column after which you want it
        });

        // Optional: Set 0 for existing rows (Laravel default usually handles this)
        \DB::table('users')->update(['UserStatus' => 0]);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('UserStatus');
        });
    }
};
