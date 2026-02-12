<?php
namespace App\Models;

use Carbon\Carbon;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

// for apis
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen'         => 'datetime',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'role',
        'bio',
        'gender',
        'relationship',
        'image',
        'password',
        'price',
        'status',
        'pronouns',
        'address',
        'refer_code',
        'referred_by',
        'is_private',
        'social_id',
        'specialization_id',
        'is_paid',
        'razorpay_account_id',
        'bank_status',
        'bank_rejection_reason',
        'payment_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_private'        => 'boolean',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    public function deleteCounselorMessages()
    {
        Message::where('receiver_id', $this->id)->delete();
    }

    protected static function booted()
    {
        /* ---------------------------------
     | WHEN USER IS UPDATED (gender)
     |----------------------------------*/
        static::saved(function ($user) {

            if ($user->wasChanged('gender')) {

                $detail = \App\Models\UserDetail::where('user_id', $user->id)->first();

                if ($detail) {
                    $detail->identity = $user->gender;
                    $detail->save();
                }
            }
        });

        /* ---------------------------------
     | WHEN USER IS DELETED
     |----------------------------------*/
        static::deleting(function ($user) {

            // If counselor → delete messages where counselor is receiver
            if ($user->role == 1) {
                \App\Models\Message::where('receiver_id', $user->id)->delete();
            }

        });
    }

    public function sociallink()
    {
        return $this->hasOne(Sociallinks::class);
    }

    // Friend requests sent by this user
    public function friendsSent()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    // Friend requests received by this user
    public function friendsReceived()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    public function latestPost()
    {
        return $this->hasOne(Post::class)->latestOfMany(); // fetch only latest post
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // this is used for friendship
    public function friendships()
    {
        return $this->hasMany(Friendship::class, 'sender_id')
            ->orWhere('receiver_id', $this->id)
            ->where('status', 'accepted');
    }

    public function sentFriendships()
    {
        return $this->hasMany(Friendship::class, 'sender_id')->where('status', 'accepted');
    }

    public function receivedFriendships()
    {
        return $this->hasMany(Friendship::class, 'receiver_id')->where('status', 'accepted');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(\App\Models\Rating::class, 'counselor_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }

    public function isOnline(): bool
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function getLastSeenDiffAttribute()
    {
        return $this->last_seen ? Carbon::parse($this->last_seen)->diffForHumans() : 'Never';
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function availabilities()
    {
        return $this->hasMany(CounselorAvailability::class, 'counselor_id');
    }

    public function allFriends()
    {
        $sent = $this->belongsToMany(User::class, 'friendships', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'accepted');

        $received = $this->belongsToMany(User::class, 'friendships', 'receiver_id', 'sender_id')
            ->wherePivot('status', 'accepted');

        return $sent->union($received);
    }

    public function friendsList()
    {
        // Fetch sent friends (users who received friendship)
        $sent = $this->sentFriendships()->with('receiver')->get()->pluck('receiver');

        // Fetch received friends (users who sent friendship)
        $received = $this->receivedFriendships()->with('sender')->get()->pluck('sender');

        // Merge both, filter out self if any (just to be safe), and return values collection
        return $sent->merge($received)
            ->filter(fn($friend) => intval($friend->id) !== intval($this->id))
            ->values();
    }

    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    public function jitsiRooms()
    {
        return $this->belongsToMany(JitsiRoom::class, 'jitsi_room_user')
            ->withPivot('is_admin')
            ->withTimestamps();
    }

    // users this user muted
    public function mutedUsers()
    {
        return $this->belongsToMany(User::class, 'muted_users', 'user_id', 'muted_user_id')
            ->withTimestamps();
    }

    // users who muted this user (optional)
    public function mutedBy()
    {
        return $this->belongsToMany(User::class, 'muted_users', 'muted_user_id', 'user_id')
            ->withTimestamps();
    }

    // Users this user has blocked
    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocks', 'user_id', 'blocked_id')
            ->withTimestamps();
    }

    // Optional: users who blocked this user
    public function blockedByUsers()
    {
        return $this->belongsToMany(User::class, 'blocks', 'blocked_id', 'user_id')
            ->withTimestamps();
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function details()
    {
        return $this->hasOne(UserDetail::class);
    }
}
