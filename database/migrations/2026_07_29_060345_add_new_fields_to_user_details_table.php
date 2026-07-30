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
        Schema::table('user_details', function (Blueprint $table) {

            // Basic Information
            $table->string('display_name')->nullable()->after('relationship_type');
            $table->date('date_of_birth')->nullable()->after('display_name');
            $table->string('height')->nullable()->after('date_of_birth');
            $table->string('city')->nullable()->after('height');
            $table->string('job_title')->nullable()->after('city');
            $table->string('education')->nullable()->after('job_title');
            $table->string('languages')->nullable()->after('education');

            // Gender
            $table->string('gender')->nullable()->after('languages');
            $table->string('pronouns')->nullable()->after('gender');

            // Lifestyle
            $table->string('smoking')->nullable()->after('bio');
            $table->string('drinking')->nullable()->after('smoking');
            $table->string('workout')->nullable()->after('drinking');
            $table->string('diet')->nullable()->after('workout');
            $table->string('pets')->nullable()->after('diet');

            // Privacy
            $table->enum('profile_visibility', ['everyone', 'verified_only'])
                ->default('everyone')
                ->after('pets');

            $table->enum('who_can_message', ['everyone', 'matches_only'])
                ->default('everyone')
                ->after('profile_visibility');

            $table->boolean('hide_distance')
                ->default(false)
                ->after('who_can_message');

            $table->boolean('hide_online_status')
                ->default(false)
                ->after('hide_distance');

            // Match Preference
            $table->integer('min_age')->default(18)->after('hide_online_status');
            $table->integer('max_age')->default(99)->after('min_age');
            $table->integer('max_distance')->default(100)->after('max_age');

            $table->boolean('verified_only')
                ->default(false)
                ->after('max_distance');

            $table->boolean('people_with_photos')
                ->default(false)
                ->after('verified_only');

            $table->boolean('similar_interests')
                ->default(false)
                ->after('people_with_photos');

            // Extra Photos
            $table->string('photo5')->nullable()->after('photo4');
            $table->string('photo6')->nullable()->after('photo5');

            // Onboarding
            $table->unsignedTinyInteger('onboarding_step')
                ->default(1)
                ->after('verification_status');

            $table->boolean('profile_completed')
                ->default(false)
                ->after('onboarding_step');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {

            $table->dropColumn([
                'display_name',
                'date_of_birth',
                'height',
                'city',
                'job_title',
                'education',
                'languages',

                'gender',
                'pronouns',

                'smoking',
                'drinking',
                'workout',
                'diet',
                'pets',

                'profile_visibility',
                'who_can_message',
                'hide_distance',
                'hide_online_status',

                'min_age',
                'max_age',
                'max_distance',

                'verified_only',
                'people_with_photos',
                'similar_interests',

                'photo5',
                'photo6',

                'onboarding_step',
                'profile_completed',
            ]);

            $table->renameColumn('about_me', 'bio');
        });
    }
};
