<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Event;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\Mute;
use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiProfileController extends Controller
{
    public function show($id)
    {
        $auth = Auth::user();
        $user = \App\Models\User::findOrFail($id);

        // Check if the authenticated user has blocked the profile owner
        $hasBlockedUser = \App\Models\Block::where('user_id', $auth->id)
            ->where('blocked_id', $user->id)
            ->exists();

        // Check if the profile owner has blocked the authenticated user
        $isBlockedByUser = \App\Models\Block::where('user_id', $user->id)
            ->where('blocked_id', $auth->id)
            ->exists();

        $isMuted = \App\Models\Mute::where('user_id', $auth->id)
            ->where('muted_user_id', $user->id)
            ->exists();

        // Friendship status
        $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $user) {
            $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($auth, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
        })->first();

        if ($friendship) {
            switch ($friendship->status) {
                case 'accepted':
                    $friendship_status = 'accepted';
                    break;
                case 'pending':
                    if ($friendship->sender_id == $auth->id) {
                        // Auth sent the request
                        $friendship_status = 'request_sent';
                    } else {
                        // Auth received the request
                        $friendship_status = 'pending_request';
                    }
                    break;
                case 'rejected':
                    $friendship_status = 'rejected';
                    break;
            }
        } else {
            $friendship_status = 'not_friends';
        }

        // If blocked in either direction
        if ($hasBlockedUser || $isBlockedByUser) {
            $posts        = collect();
            $canViewPosts = false;
            $message      = "You cannot view this profile.";
        } else {
            // By default, allow viewing if public OR if it's the user's own profile
            $canViewPosts = ! $user->is_private || $auth->id === $user->id;
            $message      = null;

            // If the account is private and it's not the auth user
            if ($user->is_private && $auth->id !== $user->id) {
                // Check if auth user is a friend
                $friendsOfUser = $user->friendsList();
                $canViewPosts  = $friendsOfUser->contains(fn($friend) => $friend->id === $auth->id);

                if (! $canViewPosts) {
                    $message = "This account is private.";
                }
            }

            // Load posts if allowed
            $posts = $canViewPosts
                ? \App\Models\Post::with(['user', 'comments.user', 'likes'])
                ->withCount(['likes', 'comments'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get()
                : collect();
        }

        // Notifications
        $notifications = $auth->unreadNotifications;
        $friends       = $user->friendsList();

        return response()->json([
            'success'           => true,
            'userProfile'       => $user,
            'posts'             => $posts,
            'notifications'     => $notifications,
            'isMuted'           => $isMuted,
            'friendship_status' => $friendship_status,
            'canViewPosts'      => $canViewPosts,
            'message'           => $message,
            'hasBlockedUser'    => $hasBlockedUser,
            'isBlockedByUser'   => $isBlockedByUser,
            'followers'         => $friends,
        ]);
    }

    public function profileDetails(Request $request)
    {
        // i get both users data based on roles
        $user = Auth::user();

        // Common data for all roles
        $notifications = $user->unreadNotifications;

        $appointments = Message::with('availability')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // If Counselee (role = 0, for example)
        if ($user->role == 0) {
            // User posts
            $posts = Post::where('user_id', $user->id)->latest()->get();

            // Friendships
            $friendships = Friendship::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })->where('status', 'accepted')->get();

            // Friend IDs
            $followerIds = $friendships->map(function ($friend) use ($user) {
                return $friend->sender_id == $user->id ? $friend->receiver_id : $friend->sender_id;
            });

            // Only user blocks (not post blocks)
            $blockedIds = \App\Models\Block::where('user_id', $user->id)
                ->whereNotNull('blocked_id')
                ->pluck('blocked_id')
                ->toArray();

            // Muted users
            $mutedIds = \App\Models\Mute::where('user_id', $user->id)
                ->pluck('muted_user_id')
                ->toArray();

            // Followers = friends excluding blocked users (muted still appear)
            $followers = User::whereIn('id', $followerIds)
                ->whereNotIn('id', $blockedIds)
                ->get();

            // Blocked users list
            $blockedUsers = User::whereIn('id', $blockedIds)->get();

            // Muted users list (exclude blocked)
            $mutedUsers = User::whereIn('id', $mutedIds)
                ->whereNotIn('id', $blockedIds)
                ->get();

            $bookmarkedPosts = \App\Models\Bookmark::where('user_id', $user->id)
                ->with('post.user')
                ->latest()
                ->get()
                ->pluck('post')
                ->filter()
                ->values();

            return response()->json([
                'success'         => true,
                'role'            => 'counselee',
                'user'            => $user,
                'is_private'      => (bool) $user->is_private,
                'uploaded_post'   => $posts,
                'notifications'   => $notifications,
                'followers'       => $followers,
                'blockedUsers'    => $blockedUsers,
                'mutedUsers'      => $mutedUsers,
                'appointments'    => $appointments,
                'bookmarkedPosts' => $bookmarkedPosts,
            ]);
        }

        // If Counselor (role = 1)
        if ($user->role == 1) {
            // Notifications
            $notifications = $user->unreadNotifications;

            // Availabilities (future dates only)
            $availabilities = $user->availabilities()
                ->where('available_date', '>=', now()->toDateString())
                ->orderBy('available_date')
                ->orderBy('start_time')
                ->get();

            // Latest 4 messages
            $messages = Message::where('receiver_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();

            // Ratings
            $averageRating = $user->ratingsReceived()->avg('rating');
            $totalReviews  = $user->ratingsReceived()->count();

            // Friend count (optional)
            $friendCount = $user->friends()->count();

            // Appointments (if relation exists)
            $appointments = Message::with([
                'availability',
                'sender:id,first_name,last_name,image',
                'receiver:id,first_name,last_name,image',
            ])
                ->where(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $specialization = $user->specialization ? [
                'id'   => $user->specialization->id,
                'name' => $user->specialization->name,
            ] : null;

            return response()->json([
                'success'        => true,
                'role'           => 'counselor',
                'user'           => $user,
                'notifications'  => $notifications,
                'availabilities' => $availabilities,
                'messages'       => $messages,
                'appointments'   => $appointments,
                'averageRating'  => round($averageRating ?? 0, 1),
                'totalReviews'   => $totalReviews,
                'friendCount'    => $friendCount,
                'specialization' => $specialization,
            ]);
        }

        // For Admin (role = 2) or other roles
        return response()->json([
            'success'       => true,
            'role'          => 'other',
            'user'          => $user,
            'notifications' => $notifications,
        ]);
    }

    public function timeline(Request $request)
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;

        // All users except logged-in user
        $all_users = \App\Models\User::where('id', '!=', $auth->id)->get();

        foreach ($all_users as $user) {
            $friendCount = \App\Models\Friendship::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })->where('status', 'accepted')->count();
            $user->friend_count = $friendCount;

            $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $user) {
                $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($auth, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
            })->first();

            $user->friendship_status = $friendship ? $friendship->status : null;
            $user->friendship_sender = $friendship ? $friendship->sender_id : null;

            $averageRating        = $user->ratingsReceived()->avg('rating');
            $user->average_rating = round($averageRating ?? 0, 1);
        }

        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        $all_posts = \App\Models\Post::with(['user', 'likes', 'comments' => function ($q) use ($hiddenUsers) {
            $q->whereNull('parent_id') // top-level only
                ->whereNotIn('user_id', $hiddenUsers)
                ->with(['user', 'replies' => function ($r) use ($hiddenUsers) {
                    $r->whereNotIn('user_id', $hiddenUsers)
                        ->with('user');
                }])
                ->latest();
        }])
            ->where('user_id', $auth->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $posts_count = \App\Models\Post::with(['user', 'likes', 'comments.user'])
            ->where('user_id', $auth->id)
            ->count();

        // Recent statuses (last 24h)
        $statuses = \App\Models\Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(fn($group) => collect($group));

        $authFriendCount = \App\Models\Friendship::where(function ($query) use ($auth) {
            $query->where('sender_id', $auth->id)
                ->orWhere('receiver_id', $auth->id);
        })
            ->where('status', 'accepted')
            ->count();

        // Friends
        $sentFriends = $auth->sentFriendships()
            ->where('status', 'accepted')
            ->with('receiver')
            ->get()
            ->pluck('receiver');

        $receivedFriends = $auth->receivedFriendships()
            ->where('status', 'accepted')
            ->with('sender')
            ->get()
            ->pluck('sender');

        $friends = $sentFriends->merge($receivedFriends)
            ->filter(fn($friend) =>
                $friend->id !== $auth->id && ! in_array($friend->id, $hiddenUsers)
            )
            ->values();

        return response()->json([
            'success'         => true,
            'user'            => $auth,
            'authFriendCount' => $authFriendCount,
            'all_users'       => $all_users,
            'all_posts'       => $all_posts,
            'notifications'   => $notifications,
            'statuses'        => $statuses,
            'friends'         => $friends,
            'posts_count'     => $posts_count,
        ]);
    }

    public function video()
    {
        $auth = Auth::user();

        // Optional: restrict route if only role=0 users can access
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        // Unread notifications of the logged-in user
        $notifications = $auth->unreadNotifications;

        // Get all counselors (role = 1) except the logged-in user
        $all_users = User::where('id', '!=', $auth->id)
            ->where('role', 1)
            ->with('specialization:id,name')
            ->get();

        // Attach extra data
        foreach ($all_users as $user) {
            $friendCount = Friendship::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })->where('status', 'accepted')->count();
            $user->friend_count = $friendCount;

            $friendship = Friendship::where(function ($q) use ($auth, $user) {
                $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($auth, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
            })->first();

            $user->friendship_status = $friendship ? $friendship->status : null;
            $user->friendship_sender = $friendship ? $friendship->sender_id : null;

            $averageRating        = $user->ratingsReceived()->avg('rating');
            $user->average_rating = round($averageRating ?? 0, 1);

            $appointments = [
                'accepted' => Message::where('receiver_id', $user->id)
                    ->where('status', 'accepted')
                    ->count(),
                'pending'  => Message::where('receiver_id', $user->id)
                    ->where('status', 'pending')
                    ->count(),
                'rejected' => Message::where('receiver_id', $user->id)
                    ->where('status', 'rejected')
                    ->count(),
            ];
            $user->appointments = $appointments;
        }

        // Fetch all posts with user, likes, and comments
        $all_posts = Post::with(['user', 'likes', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch statuses created in the last day
        $statuses = Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(fn($group) => collect($group));

        return response()->json([
            'success'       => true,
            'user'          => $auth,
            'notifications' => $notifications,
            'counselors'    => $all_users,
            'posts'         => $all_posts,
            'statuses'      => $statuses,
        ]);
    }

    public function event()
    {
        $auth = Auth::user();

        // Only allow role = 0 users
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        // Unread notifications
        $notifications = $auth->unreadNotifications;

        // Users you blocked
        // $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
        //     ->pluck('blocked_id')
        //     ->toArray();

        // // Users who blocked you
        // $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
        //     ->pluck('user_id')
        //     ->toArray();

        // // Merge both
        // $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        // // Get all users except logged-in, hidden, and non-role 0 users
        // $all_users = \App\Models\User::where('id', '!=', $auth->id)
        //     ->where('role', 0)
        //     ->whereNotIn('id', $hiddenUsers)
        //     ->with('ratingsReceived')
        //     ->inRandomOrder()
        //     ->get()
        //     ->map(function ($user) use ($auth) {
        //         // Friend count
        //         $user->friend_count = \App\Models\Friendship::where(function ($query) use ($user) {
        //             $query->where('sender_id', $user->id)
        //                 ->orWhere('receiver_id', $user->id);
        //         })->where('status', 'accepted')->count();

        //         // Friendship status
        //         $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $user) {
        //             $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
        //         })->orWhere(function ($q) use ($auth, $user) {
        //             $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
        //         })->first();

        //         $user->friendship_status = $friendship?->status;
        //         $user->friendship_sender = $friendship?->sender_id;

        //         // Average rating
        //         $user->average_rating = round($user->ratingsReceived->avg('rating') ?? 0, 1);

        //         return $user;
        //     });

        // --- Blocked Users ---
        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $blockedUsers   = array_filter($blockedUsers);
        $blockedByUsers = array_filter($blockedByUsers);

        $blockedPosts = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('post_id')
            ->pluck('post_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        // --- Muted Users ---
        $mutedUsers = \App\Models\Mute::where('user_id', $auth->id)
            ->pluck('muted_user_id')
            ->toArray();

        // --- Friend IDs (only accepted) ---
        $friendIds = \App\Models\Friendship::where(function ($q) use ($auth) {
            $q->where('sender_id', $auth->id)
                ->orWhere('receiver_id', $auth->id);
        })
            ->where('status', 'accepted')
            ->get()
            ->map(function ($f) use ($auth) {
                return $f->sender_id == $auth->id ? $f->receiver_id : $f->sender_id;
            })
            ->toArray();

        $allowedUserIds = User::where(function ($q) use ($friendIds) {
            $q->where('is_private', 0)     // public
                ->orWhereIn('id', $friendIds); // friends
        })
            ->pluck('id')
            ->toArray();

        // --- Fetch all users ---
        $all_users = \App\Models\User::where('id', '!=', $auth->id)
            ->where('role', 0)
            ->whereNotIn('id', $hiddenUsers)
            ->with('ratingsReceived')
            ->inRandomOrder()
            ->get()
            ->map(function ($user) use ($auth) {
                $friendCount = \App\Models\Friendship::where(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })->where('status', 'accepted')->count();

                $user->friend_count = $friendCount;

                $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
                })->first();

                $user->friendship_status = $friendship?->status;
                $user->friendship_sender = $friendship?->sender_id;
                $user->average_rating    = round($user->ratingsReceived->avg('rating') ?? 0, 1);

                return $user;
            });

        // --- Fetch all posts with filtered comments ---
        $all_posts = \App\Models\Post::with([
            'user',
            'likes',
            'comments' => function ($query) use ($hiddenUsers) {
                // Hide comments by blocked users
                $query->whereNotIn('user_id', $hiddenUsers)
                    ->with(['user', 'replies' => function ($q) use ($hiddenUsers) {
                        // Also hide replies by blocked users
                        $q->whereNotIn('user_id', $hiddenUsers)
                            ->with('user');
                    }]);
            },
        ])
            ->whereIn('user_id', $allowedUserIds)
            ->whereNotIn('id', $blockedPosts)
            ->whereNotIn('user_id', $hiddenUsers) // fully blocked users → hide all posts
            ->whereNotIn('user_id', $mutedUsers)  // muted users → hide all posts
            ->get()
        // this map for bookmark posts
            ->map(function ($post) use ($auth) {
                // Total comments count (main + replies)
                $post->total_comments = $post->comments->count() +
                $post->comments->sum(fn($c) => $c->replies->count());

                // Friendship status
                $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $post) {
                    $q->where('sender_id', $auth->id)->where('receiver_id', $post->user_id);
                })->orWhere(function ($q) use ($auth, $post) {
                    $q->where('sender_id', $post->user_id)->where('receiver_id', $auth->id);
                })->first();

                $post->friendship_status = $friendship?->status ?? 'not_friends';
                $post->friendship_sender = $friendship?->sender_id ?? null;

                $post->is_bookmarked = \App\Models\Bookmark::where('user_id', $auth->id)
                    ->where('post_id', $post->id)
                    ->exists();

                return $post;
            })
            ->sortByDesc(fn($post) => $post->likes->count())
            ->values();

        // $all_posts = Post::with(['user', 'likes', 'comments.user'])
        // ->get()
        // ->sortByDesc(fn($post) => $post->likes->count())
        // ->values();

        return response()->json([
            'success'       => true,
            'user'          => $auth,
            'notifications' => $notifications,
            'all_users'     => $all_users,
            'posts'         => $all_posts,
        ]);
    }

    public function feed(Request $request)
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications->map(function ($notification) {
            $data = $notification->data;

            // If this is a friend request, fetch friendship ID
            if (isset($data['follower_id'])) {
                $friendship = \App\Models\Friendship::where('sender_id', $data['follower_id'])
                    ->where('receiver_id', auth()->id())
                    ->where('status', 'pending')
                    ->first();

                if ($friendship) {
                    $data['friendship_id'] = $friendship->id;
                }
            }

            return [
                'id'         => $notification->id,
                'type'       => $notification->type,
                'data'       => $data,
                'read_at'    => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });

        $friends = $auth->friendsList()->pluck('id')->toArray();

        // --- Blocked, Muted, Hidden ---
        $blockedUsers = Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $mutedUsers = Mute::where('user_id', $auth->id)
            ->pluck('muted_user_id')
            ->toArray();

        // Blocked posts (from 'blocks' table)
        $blockedPosts = Block::where('user_id', $auth->id)
            ->whereNotNull('post_id')
            ->pluck('post_id')
            ->toArray();

        // $reportedPosts = \App\Models\Report::whereIn('reason', ['spam', 'abuse'])
        //     ->pluck('post_id')
        //     ->toArray();

        // Muted posts
        // $mutedPosts = Mute::where('user_id', $auth->id)
        //     ->whereNotNull('post_id')
        //     ->pluck('post_id')
        //     ->toArray();

        // Combine blocked & muted users/posts
        // $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers, $mutedUsers));
        // $hiddenPosts = array_unique(array_merge($blockedPosts));

        $reportedPosts = \App\Models\Report::where('user_id', $auth->id)
            ->whereNotNull('post_id')
            ->pluck('post_id')
            ->toArray();

        $reportedUsers = \App\Models\Report::where('user_id', $auth->id)
            ->whereNotNull('reported_user_id')
            ->pluck('reported_user_id')
            ->toArray();

        $usersWhoReportedMe = \App\Models\Report::where('reported_user_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge(
            $blockedUsers,
            $blockedByUsers,
            $mutedUsers,
            // $reportedUsers,
            // $usersWhoReportedMe
        ));

        $hiddenPosts = array_unique(array_merge($blockedPosts, $reportedPosts));

        // --- Posts ---
        // $all_posts = Post::with([
        //     'user',
        //     'likes',
        //     'comments' => function ($q) use ($auth) {
        //         // Blocked users
        //         $blockedUserIds = Block::where('user_id', $auth->id)
        //             ->whereNotNull('blocked_id')
        //             ->pluck('blocked_id')
        //             ->merge(
        //                 Block::where('blocked_id', $auth->id)
        //                     ->whereNotNull('user_id')
        //                     ->pluck('user_id')
        //             )
        //             ->unique()
        //             ->toArray();

        //         // Hide blocked users and private user comments
        //         $q->whereNull('parent_id')
        //             ->whereNotIn('user_id', $blockedUserIds)
        //             ->whereHas('user', function ($userQuery) use ($auth) {
        //                 $userQuery->where(function ($q2) use ($auth) {
        //                     $q2->where('is_private', 0)
        //                         ->orWhereIn('id', function ($sub) use ($auth) {
        //                             $sub->select('receiver_id')
        //                                 ->from('friendships')
        //                                 ->where('sender_id', $auth->id)
        //                                 ->where('status', 'friends')
        //                                 ->union(
        //                                     DB::table('friendships')
        //                                         ->select('sender_id')
        //                                         ->where('receiver_id', $auth->id)
        //                                         ->where('status', 'friends')
        //                                 );
        //                         });
        //                 });
        //             })
        //             ->with([
        //                 'user',
        //                 'replies' => function ($r) use ($blockedUserIds, $auth) {
        //                     $r->whereNotIn('user_id', $blockedUserIds)
        //                         ->whereHas('user', function ($userQuery) use ($auth) {
        //                             $userQuery->where(function ($q2) use ($auth) {
        //                                 $q2->where('is_private', 0)
        //                                     ->orWhereIn('id', function ($sub) use ($auth) {
        //                                         $sub->select('receiver_id')
        //                                             ->from('friendships')
        //                                             ->where('sender_id', $auth->id)
        //                                             ->where('status', 'friends')
        //                                             ->union(
        //                                                 DB::table('friendships')
        //                                                     ->select('sender_id')
        //                                                     ->where('receiver_id', $auth->id)
        //                                                     ->where('status', 'friends')
        //                                             );
        //                                     });
        //                             });
        //                         })
        //                         ->with('user');
        //                 },
        //             ])
        //             ->latest();
        //     },
        // ])
        //     ->whereNotIn('user_id', $hiddenUsers)
        //     ->whereNotIn('id', $hiddenPosts)
        //     ->where(function ($q) use ($auth, $reportedPosts) {
        //         $q->whereNotIn('id', $reportedPosts)
        //             ->orWhere('user_id', $auth->id);
        //     })
        //     ->where(function ($q) use ($auth, $friends) {
        //         $q->where('user_id', $auth->id)
        //             ->orWhereHas('user', function ($u) use ($auth, $friends) {
        //                 $u->where('is_private', 0)
        //                     ->orWhere(function ($q2) use ($friends) {
        //                         $q2->where('is_private', 1)
        //                             ->whereIn('users.id', $friends);
        //                     });
        //             });
        //     })
        //     ->whereDoesntHave('user', fn($q) =>
        //         $q->whereHas('blockedUsers', fn($q2) => $q2->where('blocks.blocked_id', $auth->id))
        //     )
        //     ->whereDoesntHave('user', fn($q) =>
        //         $q->whereHas('blockedByUsers', fn($q2) => $q2->where('blocks.user_id', $auth->id))
        //     )
        //     ->inRandomOrder()
        //     ->get()
        //     ->map(function ($p) use ($auth) {
        //         // Calculate total comments (including replies)
        //         $p->total_comments = $p->comments->count() + $p->comments->sum(fn($c) => $c->replies->count());

        //         // Friendship status between auth user and post owner
        //         $friendship = Friendship::where(function ($q) use ($auth, $p) {
        //             $q->where('sender_id', $auth->id)->where('receiver_id', $p->user_id);
        //         })->orWhere(function ($q) use ($auth, $p) {
        //             $q->where('sender_id', $p->user_id)->where('receiver_id', $auth->id);
        //         })->first();

        //         $p->friendship_status = $friendship?->status ?? 'not_friends';
        //         $p->friendship_sender = $friendship?->sender_id ?? null;

        //         return $p;
        //     });

        $all_posts = Post::with([
            'user',
            'likes',
            'comments' => function ($q) use ($auth) {
                // IDs of users blocked by auth or who have blocked auth
                $blockedUserIds = Block::where('user_id', $auth->id)
                    ->whereNotNull('blocked_id')
                    ->pluck('blocked_id')
                    ->merge(
                        Block::where('blocked_id', $auth->id)
                            ->whereNotNull('user_id')
                            ->pluck('user_id')
                    )
                    ->unique()
                    ->toArray();

                $q->whereNull('parent_id')
                    ->whereNotIn('user_id', $blockedUserIds)
                    ->whereHas('user', function ($userQuery) use ($auth) {
                        $userQuery->where('is_private', 0) // public
                            ->orWhere('id', $auth->id);        // self
                    })
                    ->with(['user', 'replies' => function ($r) use ($blockedUserIds, $auth) {
                        $r->whereNotIn('user_id', $blockedUserIds)
                            ->whereHas('user', function ($userQuery) use ($auth) {
                                $userQuery->where('is_private', 0)
                                    ->orWhere('id', $auth->id);
                            })
                            ->with('user');
                    }])
                    ->latest();
            },
        ])
            ->whereNotIn('user_id', $hiddenUsers)
            ->whereNotIn('id', $hiddenPosts)
        // ->where(function ($q) use ($auth, $reportedPosts) {
        //     $q->whereNotIn('id', $reportedPosts)
        //         ->orWhere('user_id', $auth->id);
        // })
            ->where(function ($q) use ($auth, $friends) {
                $q->where('user_id', $auth->id)
                    ->orWhereHas('user', function ($u) use ($friends) {
                        $u->where('is_private', 0)
                            ->orWhereIn('users.id', $friends); // include private friends
                    });
            })
            ->whereDoesntHave('user', fn($q) =>
                $q->whereHas('blockedUsers', fn($q2) => $q2->where('blocks.blocked_id', $auth->id))
            )
            ->whereDoesntHave('user', fn($q) =>
                $q->whereHas('blockedByUsers', fn($q2) => $q2->where('blocks.user_id', $auth->id))
            )
            ->inRandomOrder()
            ->get()
            ->map(function ($p) use ($auth) {
                // Total comments (including replies)
                $p->total_comments = $p->comments->count() + $p->comments->sum(fn($c) => $c->replies->count());

                // Friendship status between auth user and post owner
                $friendship = Friendship::where(function ($q) use ($auth, $p) {
                    $q->where('sender_id', $auth->id)->where('receiver_id', $p->user_id);
                })->orWhere(function ($q) use ($auth, $p) {
                    $q->where('sender_id', $p->user_id)->where('receiver_id', $auth->id);
                })->first();

                $p->friendship_status = $friendship?->status ?? 'not_friends';
                $p->friendship_sender = $friendship?->sender_id ?? null;

                $p->is_bookmarked = \App\Models\Bookmark::where('user_id', $auth->id)
                    ->where('post_id', $p->id)
                    ->exists();

                return $p;
            });

        // --- All Users ---
        $all_users = User::where('id', '!=', $auth->id)
            ->whereNotIn('id', $hiddenUsers)
            ->with(['ratingsReceived', 'specialization'])
            ->inRandomOrder()
            ->get();

        foreach ($all_users as $user) {
            $friendCount = Friendship::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })->where('status', 'accepted')->count();

            $user->friend_count = $friendCount;
            $user->is_friend    = in_array($user->id, $friends);

            $friendship = Friendship::where(function ($q) use ($auth, $user) {
                $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($auth, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
            })->first();

            $user->friendship_status = $friendship?->status;
            $user->friendship_sender = $friendship?->sender_id;

            $averageRating        = $user->ratingsReceived->avg('rating');
            $user->average_rating = round($averageRating ?? 0, 1);
        }

        // Statuses (last 24h)
        $userId    = auth()->id();
        $friendIds = \DB::table('friendships')
            ->where('status', 'accepted')
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->get()
            ->map(function ($friendship) use ($userId) {
                return $friendship->sender_id == $userId
                    ? $friendship->receiver_id
                    : $friendship->sender_id;
            })
            ->unique()
            ->values()
            ->toArray();

        $friendIds[] = $auth->id; // include myself
                                  // dd($friendIds);

        $statuses = Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->whereIn('user_id', $friendIds)
            ->whereNotIn('user_id', $hiddenUsers)
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(fn($group) => collect($group));

        // --- Events (nearby + upcoming) ---
        $userAddress = $auth->address ?? '';
        $now         = Carbon::now();
        $eventsQuery = Event::where('status', 'approved');

        if (! empty($userAddress)) {
            $addressParts = array_map('trim', explode(',', $userAddress));
            $eventsQuery->where(function ($query) use ($addressParts) {
                foreach ($addressParts as $part) {
                    if (! empty($part)) {
                        $query->orWhereRaw('LOWER(city) LIKE ?', ['%' . strtolower($part) . '%']);
                    }
                }
            });
        } else {
            $eventsQuery->whereRaw('0=1');
        }

        $eventsQuery->where(function ($query) use ($now) {
            $query->whereDate('timing', '>', $now->toDateString())
                ->orWhere(function ($q) use ($now) {
                    $q->whereDate('timing', '=', $now->toDateString())
                        ->whereTime('timing', '>=', $now->toTimeString());
                });
        });

        $events = $eventsQuery->get()->map(function ($e) {
            $e->formatted_timing = Carbon::parse($e->timing)->format('d M Y h:i A');
            return $e;
        });

        // --- API Response ---
        return response()->json([
            'status'    => true,
            'user'      => $auth,
            // 'notifications' => $notifications,
            'all_posts' => $all_posts,
            'all_users' => $all_users,
            'statuses'  => $statuses,
            'events'    => $events,
        ], 200);
    }

    // this is for chatting page data
    // public function messages($receiver_id = null)
    // {
    //     $user = Auth::user();
    //     abort_if($user->role != 0, 403, 'Unauthorized access');

    //     // Unread notifications
    //     $notifications = $user->unreadNotifications;

    //     // Get all accepted friendships
    //     $friendships = \App\Models\Friendship::where('status', 'accepted')
    //         ->where(function ($query) use ($user) {
    //             $query->where('sender_id', $user->id)
    //                 ->orWhere('receiver_id', $user->id);
    //         })
    //         ->get();

    //     // Extract friend IDs
    //     $friendIds = $friendships->map(function ($friendship) use ($user) {
    //         return $friendship->sender_id == $user->id
    //             ? $friendship->receiver_id
    //             : $friendship->sender_id;
    //     })->toArray();

    //     // Get blocked users
    //     $blockedUsers = \App\Models\Block::where('user_id', $user->id)
    //         ->pluck('blocked_id')
    //         ->toArray();

    //     $blockedByUsers = \App\Models\Block::where('blocked_id', $user->id)
    //         ->pluck('user_id')
    //         ->toArray();

    //     $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

    //     // Only valid friends
    //     $validFriendIds = array_diff($friendIds, $hiddenUsers);

    //     $friends = \App\Models\User::whereIn('id', $validFriendIds)->get();

    //     // Check receiver authorization
    //     $receiver = null;
    //     if ($receiver_id) {
    //         if (in_array($receiver_id, $validFriendIds)) {
    //             $receiver = \App\Models\User::find($receiver_id);
    //         } else {
    //             return response()->json([
    //                 'status'  => false,
    //                 'message' => 'You are not authorized to view this chat.',
    //             ], 403);
    //         }
    //     }

    //     $agoraAppId = config('services.agora.app_id');

    //     return response()->json([
    //         'status'        => true,
    //         'user'          => $user,
    //         'notifications' => $notifications,
    //         'receiver'      => $receiver,
    //         'friends'       => $friends,
    //         'agoraAppId'    => $agoraAppId,
    //         'userId'        => $user->id,
    //         'hiddenUsers'   => $hiddenUsers,
    //     ], 200);
    // }

    public function messages($receiver_id = null)
    {
        $user = Auth::user();
        abort_if($user->role != 0, 403, 'Unauthorized access');

        /* ================= UNREAD NOTIFICATIONS ================= */
        $notifications = $user->unreadNotifications;

        /* ================= FRIENDS ================= */
        $friendIds = \App\Models\Friendship::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->get()
            ->map(fn($f) => $f->sender_id == $user->id ? $f->receiver_id : $f->sender_id)
            ->toArray();

        /* ================= BLOCKED USERS ================= */
        $blocked     = \App\Models\Block::where('user_id', $user->id)->pluck('blocked_id')->toArray();
        $blockedBy   = \App\Models\Block::where('blocked_id', $user->id)->pluck('user_id')->toArray();
        $hiddenUsers = array_unique(array_merge($blocked, $blockedBy));

        // Remove hidden users from friends
        $friendIds = array_diff($friendIds, $hiddenUsers);
        $friends   = \App\Models\User::whereIn('id', $friendIds)->get();

        /* ================= COUNSELORS ================= */
        $counselorIds = \App\Models\Message::where('sender_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('receiver_id')
            ->toArray();

        $counselors = \App\Models\User::whereIn('id', $counselorIds)
            ->where('role', 1)
            ->get();

        /* ================= DATING CHAT USERS ================= */
        $datingUserIds = \App\Models\DatingMessage::where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })
            ->selectRaw("
        CASE
            WHEN sender_id = {$user->id} THEN receiver_id
            ELSE sender_id
        END as user_id
    ")
            ->pluck('user_id')
            ->unique()
            ->toArray();

        $datingUserIds = array_diff($datingUserIds, $hiddenUsers);

        $datingUsers = \App\Models\User::with('details')
            ->whereIn('id', $datingUserIds)
            ->where('role', 0)
            ->get()
            ->map(fn($u) => (object) [
                'id'         => $u->id,
                'name'       => $u->first_name . ' ' . $u->last_name,
                'image'      => $u->details->photo1 ?? '0',
                'UserStatus' => $u->UserStatus,
                'chat_type'  => 'dating',
            ]);

        /* ================= MERGE ALL CHAT USERS ================= */
        $chatUsers = collect();

        foreach ($friends as $f) {
            $chatUsers->push((object) [
                'id'         => $f->id,
                'name'       => $f->first_name . ' ' . $f->last_name,
                'image'      => $f->image,
                'UserStatus' => $f->UserStatus,
                'chat_type'  => 'friend',
            ]);
        }

        foreach ($counselors as $c) {
            $chatUsers->push((object) [
                'id'         => $c->id,
                'name'       => $c->first_name . ' ' . $c->last_name,
                'image'      => $c->image,
                'UserStatus' => $c->UserStatus,
                'chat_type'  => 'counselor',
            ]);
        }

        foreach ($datingUsers as $d) {
            $chatUsers->push($d);
        }

        /* ================= RECEIVER CHECK ================= */
        $receiver         = null;
        $receiverChatType = null;
        $chatMessages     = collect();

        $receiverType = request()->get('type');

        // optional hardening
        if ($receiverType) {
            abort_if(! in_array($receiverType, ['friend', 'dating', 'counselor']), 403);
        }

        if ($receiver_id && $receiverType) {

            // strict match: id + chat_type
            $receiverEntry = $chatUsers->first(function ($u) use ($receiver_id, $receiverType) {
                return (int) $u->id === (int) $receiver_id
                && $u->chat_type === $receiverType;
            });

            // block URL tampering
            abort_if(! $receiverEntry, 403);

            /* ================= LOAD RECEIVER ================= */
            if ($receiverType === 'dating') {

                // load dating user with details
                $receiver = User::with('details')->findOrFail($receiver_id);

                // dating profile image
                $receiver->chat_image = optional($receiver->details)->photo1;

                /* ================= FETCH DATING CHAT ================= */
                $chatMessages = \App\Models\DatingMessage::where(function ($q) use ($user, $receiver_id) {
                    $q->where('sender_id', $user->id)
                        ->where('receiver_id', $receiver_id);
                })
                    ->orWhere(function ($q) use ($user, $receiver_id) {
                        $q->where('sender_id', $receiver_id)
                            ->where('receiver_id', $user->id);
                    })
                    ->orderBy('created_at')
                    ->get();

            } else {
                // friend / counselor
                $receiver             = User::findOrFail($receiver_id);
                $receiver->chat_image = $receiver->image;
            }

            $receiverChatType = $receiverType;
        }

        /* ================= RESPONSE ================= */
        return response()->json([
            'status'           => true,
            'user'             => $user,
            'notifications'    => $notifications,
            'friends'          => $chatUsers,
            'receiver'         => $receiver,
            'receiverChatType' => $receiverChatType,
            'chatMessages'     => $chatMessages,
            'hiddenUsers'      => $hiddenUsers,
            'userId'           => $user->id,
        ]);
    }

    public function blog(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Get unread notifications
        $notifications = $user->unreadNotifications;

        // Get all appointments of the user
        $appointments = Message::with(['availability', 'sender', 'receiver'])
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $now = Carbon::now();

        // Format availability times + filter future sessions
        $appointments->each(function ($appointment) use ($now) {
            if ($appointment->availability) {
                $start = Carbon::parse($appointment->availability->start_time);
                $end   = Carbon::parse($appointment->availability->end_time);

                $appointment->availability->date      = $start->format('D, M d Y');
                $appointment->availability->startTime = $start->format('h:i A');
                $appointment->availability->endTime   = $end->format('h:i A');
                $appointment->availability->isFuture  = $end->greaterThan($now); // session not ended
            }
        });

        // Accepted appointment
        $acceptedAppointment = $appointments->firstWhere('status', 'accepted');

        // Only show accepted appointment if session not ended
        if ($acceptedAppointment && $acceptedAppointment->availability) {
            $endTime = Carbon::parse($acceptedAppointment->availability->end_time);
            if ($endTime->lessThanOrEqualTo($now)) {
                $acceptedAppointment = null;
            } else {
                $start                                        = Carbon::parse($acceptedAppointment->availability->start_time);
                $acceptedAppointment->availability->date      = $start->format('D, M d Y');
                $acceptedAppointment->availability->startTime = $start->format('h:i A');
                $acceptedAppointment->availability->endTime   = Carbon::parse($acceptedAppointment->availability->end_time)->format('h:i A');
            }
        }

        return response()->json([
            'success'             => true,
            'user'                => $user,
            'notifications'       => $notifications,
            'appointments'        => $appointments,
            'acceptedAppointment' => $acceptedAppointment,
        ]);
    }

    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();

        // Store 1 if checked, 0 if unchecked
        $user->is_private = $request->input('is_private') ? 1 : 0;
        $user->save();

        return response()->json([
            'success'    => true,
            'is_private' => $user->is_private,
        ]);
    }

    public function fetchNotifications(Request $request)
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications->map(function ($notification) {
            $data = $notification->data;

            // If this is a friend request, fetch friendship ID
            if (isset($data['follower_id'])) {
                $friendship = \App\Models\Friendship::where('sender_id', $data['follower_id'])
                    ->where('receiver_id', auth()->id())
                    ->where('status', 'pending')
                    ->first();

                if ($friendship) {
                    $data['friendship_id'] = $friendship->id;
                }
            }

            return [
                'id'         => $notification->id,
                'type'       => $notification->type,
                'data'       => $data,
                'read_at'    => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });

        // --- API Response ---
        return response()->json([
            'status'        => true,
            'user'          => $auth,
            'notifications' => $notifications,
        ], 200);
    }
}
