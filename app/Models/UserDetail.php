<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $fillable = [

        'user_id',

        // Identity
        'identity',
        'preference',
        'relationship_type',

        // Basic Info
        'display_name',
        'date_of_birth',
        'height',
        'city',
        'job_title',
        'education',
        'languages',

        // Gender
        'gender',
        'pronouns',

        // About
        'bio',

        // Interests
        'interest',

        // Lifestyle
        'smoking',
        'drinking',
        'workout',
        'diet',
        'pets',

        // Privacy
        'profile_visibility',
        'who_can_message',
        'hide_distance',
        'hide_online_status',

        // Match Preference
        'min_age',
        'max_age',
        'max_distance',
        'verified_only',
        'people_with_photos',
        'similar_interests',

        // Photos
        'photo1',
        'photo2',
        'photo3',
        'photo4',
        'photo5',
        'photo6',
        'selfie',

        // Verification
        'verification_status',

        // Onboarding
        'onboarding_step',
        'profile_completed',

        // Verification
        'verification_status',
        'verification_method',
        'verification_selfie',
        'verification_id',
        'verified_at',
        'verified_by',
        'rejection_reason',
    ];

    protected $casts = [

        'date_of_birth'      => 'date',

        'hide_distance'      => 'boolean',
        'hide_online_status' => 'boolean',

        'verified_only'      => 'boolean',
        'people_with_photos' => 'boolean',
        'similar_interests'  => 'boolean',

        'profile_completed'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
