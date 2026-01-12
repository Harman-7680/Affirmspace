<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Block;
use App\Models\DatingMessage;
use App\Models\Event;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\Post;
use App\Models\Rating;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function show($id)
    {
        $auth = Auth::user();

        if ($auth->id == $id) {
            Auth::logout();
            return redirect()->route('login');
        }

        $user = \App\Models\User::findOrFail($id);

        // Check if the authenticated user has blocked the profile owner
        $hasBlockedUser = \App\Models\Block::where('user_id', $auth->id)
            ->where('blocked_id', $user->id)
            ->exists();

        // Check if the profile owner has blocked the authenticated user
        $isBlockedByUser = \App\Models\Block::where('user_id', $user->id)
            ->where('blocked_id', $auth->id)
            ->exists();

        // If blocked in either direction
        if ($hasBlockedUser || $isBlockedByUser) {
            $posts        = collect();
            $canViewPosts = false;
            $message      = "You can’t interact with this user.";
        } else {
            // By default, allow viewing if public OR if it's the user's own profile
            $canViewPosts = ! $user->is_private || $auth->id === $user->id;
            $message      = null;

            // If the account is private and it's not the auth user
            if ($user->is_private && $auth->id !== $user->id) {
                                                       // Check if auth user is a friend
                $friendsOfUser = $user->friendsList(); // accepted friends of the user
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
                : collect(); // empty collection if not allowed
        }

        $notifications = $auth->unreadNotifications;

        return view('user.profile', [
            'userProfile'     => $user,
            'posts'           => $posts,
            'notifications'   => $notifications,
            'canViewPosts'    => $canViewPosts,
            'message'         => $message,
            'hasBlockedUser'  => $hasBlockedUser,
            'isBlockedByUser' => $isBlockedByUser,
        ]);
    }

    public function edit(Request $request): View
    {
        $user = Auth::user();

        // User posts & notifications
        $posts         = Post::where('user_id', $user->id)->latest()->get();
        $notifications = $user->unreadNotifications;

        // Friendships
        $friendships = Friendship::where(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })->where('status', 'accepted')->get();

        $friendIds = $friendships->map(function ($friend) use ($user) {
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

        // Followers = friends excluding **blocked users** (mute does not remove from followers)
        $followers = \App\Models\User::whereIn('id', $friendIds)
            ->whereNotIn('id', $blockedIds)
            ->get();

        // Blocked users list
        $blockedUsers = \App\Models\User::whereIn('id', $blockedIds)->get();

        // Muted users list (still keep friends in followers)
        $mutedUsers = \App\Models\User::whereIn('id', $mutedIds)
            ->whereNotIn('id', $blockedIds) // if user is blocked, show in blocked, not muted
            ->get();

        // Appointments / messages
        $appointments = Message::with('availability')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $bookmarkedPosts = \App\Models\Bookmark::where('user_id', $user->id)
            ->with('post.user')
            ->latest()
            ->get()
            ->pluck('post')
            ->filter();

        return view('profile.edit', [
            'user'            => $user,
            'uploaded_post'   => $posts,
            'notifications'   => $notifications,
            'followers'       => $followers,
            'appointments'    => $appointments,
            'blockedUsers'    => $blockedUsers,
            'mutedUsers'      => $mutedUsers,
            'bookmarkedPosts' => $bookmarkedPosts,
        ]);
    }

    /**
     * Update the user's profile information.
     */

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user      = $request->user();
        $validated = $request->validated();

        // Fill other profile fields
        $user->fill($validated);

        // If email is updated, reset verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            if ($user->image && $user->image !== '0' && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $path        = $request->file('image')->store('profile_images', 'public');
            $user->image = $path;
        }

        $user->save();

        // Redirect based on role
        if ($user->role == 0) {
            return Redirect::route('profile.edit')->with('success', 'Profile Updated');
        } elseif ($user->role == 1) {
            return Redirect::route('counseler')->with('success', 'Profile Updated');
        } elseif ($user->role == 2) {
            return redirect()->back()->with('status', 'Profile Updated');
        } else {
            return redirect()->back()->with('success', 'Profile Updated');
        }
    }

    /**
     * Delete the user's account.
     */

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('status', 'profile-deleted');
    }

    public function links(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'facebook'  => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'twitter'   => ['nullable', 'url'],
            'youtube'   => ['nullable', 'url'],
            'github'    => ['nullable', 'url'],
        ]);

        $social = $user->sociallink;
        if ($social) {
            $social->update($validated);
        } else {
            $user->sociallink()->create($validated);
        }

        return back()->with('success', 'Social Links Updated');
    }

    // public function feed()
    // {
    //     abort_if(Auth::user()->role != 0, 403, 'Unauthorized access');

    //     $auth          = Auth::user();
    //     $notifications = $auth->unreadNotifications;
    //     $all_users     = \App\Models\User::where('id', '!=', $auth->id)->get();

    //     foreach ($all_users as $user) {
    //         $friendCount = \App\Models\Friendship::where(function ($query) use ($user) {
    //             $query->where('sender_id', $user->id)
    //                 ->orWhere('receiver_id', $user->id);
    //         })->where('status', 'accepted')->count();
    //         $user->friend_count = $friendCount;

    //         $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $user) {
    //             $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
    //         })->orWhere(function ($q) use ($auth, $user) {
    //             $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
    //         })->first();

    //         $user->friendship_status = $friendship ? $friendship->status : null;
    //         $user->friendship_sender = $friendship ? $friendship->sender_id : null;

    //         $averageRating        = $user->ratingsReceived()->avg('rating');
    //         $user->average_rating = round($averageRating ?? 0, 1);
    //     }

    //     $all_posts = Post::with(['user', 'likes', 'comments.user'])
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     // if i need to show all users statuses
    //     $statuses = Status::with('user')
    //         ->where('created_at', '>=', now()->subDay())
    //         ->latest()
    //         ->get()
    //         ->groupBy('user_id')
    //         ->map(fn($group) => collect($group));

    //     $friendIds = \App\Models\Friendship::where(function ($query) use ($auth) {
    //         $query->where('sender_id', $auth->id)
    //             ->orWhere('receiver_id', $auth->id);
    //     })
    //         ->where('status', 'accepted')
    //         ->get()
    //         ->map(function ($friendship) use ($auth) {
    //             return $friendship->sender_id === $auth->id
    //             ? $friendship->receiver_id
    //             : $friendship->sender_id;
    //         })
    //         ->toArray();

    //     $statuses = Status::with('user')
    //         ->where('created_at', '>=', now()->subDay())
    //         ->whereIn('user_id', $friendIds)
    //         ->latest()
    //         ->get()
    //         ->groupBy('user_id')
    //         ->map(fn($group) => collect($group));

    //     return view('user.feed', [
    //         'user'          => $auth,
    //         'other_users'   => $all_posts,
    //         'all_users'     => $all_users,
    //         'notifications' => $notifications,
    //         'statuses'      => $statuses,
    //     ]);
    // }

    public function notifications()
    {
        $auth          = Auth::user();
        $notifications = $auth->unreadNotifications;

        return view('user.notifications', [
            'user'          => $auth,
            'notifications' => $notifications,
        ]);
    }

    public function feed()
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;

        // Friends of auth
        $friends = $auth->friendsList()->pluck('id')->toArray();

        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        $mutedUsers = \App\Models\Mute::where('user_id', $auth->id)
            ->pluck('muted_user_id')
            ->toArray();

        // Blocked posts (from same 'blocks' table)
        $blockedPosts = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('post_id')
            ->pluck('post_id')
            ->toArray();

        // $reportedPosts = \App\Models\Report::whereIn('reason', ['spam', 'abuse'])
        //     ->pluck('post_id')
        //     ->toArray();

        // // All users to hide
        // $hiddenUsers  = array_unique(array_merge($blockedUsers, $blockedByUsers, $mutedUsers));
        // $hidden_Users = array_unique(array_merge($blockedUsers, $blockedByUsers));

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

        $hidden_Users = array_unique(array_merge($blockedUsers, $blockedByUsers));

        // // All posts
        // $all_posts = Post::with(['user', 'likes', 'comments' => function ($q) {
        //     $q->whereNull('parent_id')->with(['user', 'replies.user'])->latest();
        // }])
        //     ->whereNotIn('user_id', $hiddenUsers) // hide blocked/muted users’ posts
        //     ->whereNotIn('id', $blockedPosts)     // hide blocked posts
        //     ->where(function ($q) use ($auth, $friends) {
        //         $q->where('user_id', $auth->id)
        //             ->orWhereHas('user', function ($u) use ($auth, $friends) {
        //                 $u->where('is_private', 0)
        //                     ->orWhere(function ($q2) use ($friends, $auth) {
        //                         $q2->where('is_private', 1)
        //                             ->whereIn('users.id', $friends);
        //                     });
        //             });
        //     })
        // // Exclude posts from users who have blocked auth
        //     ->whereDoesntHave('user', function ($q) use ($auth) {
        //         $q->whereHas('blockedUsers', function ($q2) use ($auth) {
        //             $q2->where('blocks.blocked_id', $auth->id);
        //         });
        //     })
        // // Exclude posts of users you have blocked
        //     ->whereDoesntHave('user', function ($q) use ($auth) {
        //         $q->whereHas('blockedByUsers', function ($q2) use ($auth) {
        //             $q2->where('blocks.user_id', $auth->id);
        //         });
        //     })
        // // ->orderBy('created_at', 'desc')
        //     ->inRandomOrder()
        //     ->get()
        //     ->map(function ($p) {
        //         $p->total_comments = $p->comments->count() + $p->comments->sum(fn($c) => $c->replies->count());
        //         return $p;
        //     });

        // All posts
        // $all_posts = Post::with(['user', 'likes', 'comments' => function ($q) use ($auth) {
        //     // Hide comments from users who are blocked or have blocked auth
        //     $blockedUserIds = \App\Models\Block::where('user_id', $auth->id)
        //         ->whereNotNull('blocked_id')
        //         ->pluck('blocked_id')
        //         ->merge(
        //             \App\Models\Block::where('blocked_id', $auth->id)
        //                 ->whereNotNull('user_id')
        //                 ->pluck('user_id')
        //         )
        //         ->unique()
        //         ->toArray();

        //     $q->whereNull('parent_id')
        //         ->whereNotIn('user_id', $blockedUserIds) // hide blocked users' comments
        //         ->with(['user', 'replies' => function ($r) use ($blockedUserIds) {
        //             // Hide replies by blocked users too
        //             $r->whereNotIn('user_id', $blockedUserIds)->with('user');
        //         }])
        //         ->latest();
        // }])
        //     ->whereNotIn('user_id', $hiddenUsers) // hide blocked/muted users’ posts
        //     ->whereNotIn('id', $blockedPosts)     // hide blocked posts
        //     ->where(function ($q) use ($auth, $reportedPosts) {
        //         $q->whereNotIn('id', $reportedPosts)
        //             ->orWhere('user_id', $auth->id);
        //     })
        //     ->where(function ($q) use ($auth, $friends) {
        //         $q->where('user_id', $auth->id)
        //             ->orWhereHas('user', function ($u) use ($auth, $friends) {
        //                 $u->where('is_private', 0)
        //                     ->orWhere(function ($q2) use ($friends, $auth) {
        //                         $q2->where('is_private', 1)
        //                             ->whereIn('users.id', $friends);
        //                     });
        //             });
        //     })
        // // Exclude posts from users who have blocked auth
        //     ->whereDoesntHave('user', function ($q) use ($auth) {
        //         $q->whereHas('blockedUsers', function ($q2) use ($auth) {
        //             $q2->where('blocks.blocked_id', $auth->id);
        //         });
        //     })
        // // Exclude posts of users you have blocked
        //     ->whereDoesntHave('user', function ($q) use ($auth) {
        //         $q->whereHas('blockedByUsers', function ($q2) use ($auth) {
        //             $q2->where('blocks.user_id', $auth->id);
        //         });
        //     })
        //     ->inRandomOrder()
        //     ->get()
        //     ->map(function ($p) {
        //         $p->total_comments = $p->comments->count() + $p->comments->sum(fn($c) => $c->replies->count());
        //         return $p;
        //     });

        $all_posts = Post::with([
            'user',
            'likes',
            'comments' => function ($q) use ($auth, $friends) {
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
                    ->whereHas('user', function ($userQuery) use ($auth, $friends) {
                        $userQuery->where('is_private', 0) // public user
                            ->orWhere('id', $auth->id)         // auth can always see own comments
                            ->orWhereIn('id', $friends);       // include private friends
                    })
                    ->with(['user', 'replies' => function ($r) use ($blockedUserIds, $auth, $friends) {
                        $r->whereNotIn('user_id', $blockedUserIds)
                            ->whereHas('user', function ($userQuery) use ($auth, $friends) {
                                $userQuery->where('is_private', 0)
                                    ->orWhere('id', $auth->id)
                                    ->orWhereIn('id', $friends); // include private friends
                            })
                            ->with('user');
                    }])
                    ->latest();
            },
        ])
            ->whereNotIn('user_id', $hiddenUsers)
            ->whereNotIn('id', $blockedPosts)
        // ->where(function ($q) use ($auth, $reportedPosts) {
        //     $q
        //         ->whereNotIn('id', $reportedPosts)
        //         ->orWhere('user_id', $auth->id);
        // })
            ->where(function ($q) use ($auth, $friends) {
                $q->where('user_id', $auth->id)
                    ->orWhereHas('user', function ($u) use ($friends) {
                        $u->where('is_private', 0)
                            ->orWhereIn('users.id', $friends); // show private friends' posts
                    });
            })
            ->whereDoesntHave('user', function ($q) use ($auth) {
                $q->whereHas('blockedUsers', fn($q2) => $q2->where('blocks.blocked_id', $auth->id));
            })
            ->whereDoesntHave('user', function ($q) use ($auth) {
                $q->whereHas('blockedByUsers', fn($q2) => $q2->where('blocks.user_id', $auth->id));
            })
            ->inRandomOrder()
        // ->orderBy('posts.created_at', 'desc')
            ->paginate(1)
        // through
        // ->get()
            ->through(function ($p) {
                $p->total_comments = $p->comments->count() + $p->comments->sum(fn($c) => $c->replies->count());

                // $p->is_bookmarked = \App\Models\Bookmark::where('user_id', $auth->id)
                //     ->where('post_id', $p->id)
                //     ->exists();
                return $p;
            });

        // Fetch all visible users
        $all_users = \App\Models\User::where('id', '!=', $auth->id)
            ->whereNotIn('id', $hidden_Users)
            ->with(['ratingsReceived', 'specialization'])
            ->inRandomOrder()
            ->get();

        // Enhance user data
        foreach ($all_users as $user) {
            $friendCount = Friendship::where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })->where('status', 'accepted')->count();
            $user->friend_count = $friendCount;

            $user->is_friend = in_array($user->id, $friends);

            $friendship = Friendship::where(function ($q) use ($auth, $user) {
                $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($auth, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
            })->first();

            $user->friendship_status = $friendship?->status;
            $user->friendship_sender = (int) ($friendship->sender_id ?? 0);

            $averageRating        = $user->ratingsReceived->avg('rating');
            $user->average_rating = round($averageRating ?? 0, 1);
        }

        // Statuses (last 24h)
        $friendIds = Friendship::where(function ($query) use ($auth) {
            $query->where('sender_id', $auth->id)
                ->orWhere('receiver_id', $auth->id);
        })
            ->where('status', 'accepted')
            ->get()
            ->map(function ($friendship) use ($auth) {
                return $friendship->sender_id === $auth->id
                    ? $friendship->receiver_id
                    : $friendship->sender_id;
            })
            ->toArray();

        $friendIds[] = $auth->id;

        // Fetch statuses from friends + self, excluding hidden users
        $statuses = \App\Models\Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->whereIn('user_id', $friendIds)
            ->whereNotIn('user_id', $hidden_Users)
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(fn($group) => collect($group));

        // Events (nearby & upcoming)
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

        return view('user.feed', [
            'user'          => $auth,
            'other_users'   => $all_posts,
            'all_users'     => $all_users,
            'notifications' => $notifications,
            'statuses'      => $statuses,
            'events'        => $events,
        ]);
    }

    // public function markAllNotificationsRead()
    // {
    //     Auth::user()->unreadNotifications->markAsRead();
    //     return back()->with('status', 'All notifications marked as read.');
    // }

    public function clear($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if (! $notification) {
            return response()->json(['status' => 'error', 'message' => 'Notification not found']);
        }

        $notification->delete();

        return response()->json(['status' => 'success']);
    }

    public function clearAllNotifications()
    {
        Auth::user()->notifications()->delete();
        return back()->with('status', 'All notifications cleared.');
    }

    // public function messages($receiver_id = null)
    // {
    //     abort_if(Auth::user()->role != 0, 403, 'Unauthorized access');

    //     $user          = Auth::user();
    //     $notifications = $user->unreadNotifications;

    //     // Accepted friendships
    //     $friendships = \App\Models\Friendship::where('status', 'accepted')
    //         ->where(function ($query) use ($user) {
    //             $query->where('sender_id', $user->id)
    //                 ->orWhere('receiver_id', $user->id);
    //         })
    //         ->get();

    //     // Friend IDs
    //     $friendIds = $friendships->map(function ($friendship) use ($user) {
    //         return $friendship->sender_id == $user->id
    //             ? $friendship->receiver_id
    //             : $friendship->sender_id;
    //     })->toArray();

    //     // Blocked users
    //     $blockedUsers = \App\Models\Block::where('user_id', $user->id)
    //         ->pluck('blocked_id')
    //         ->toArray();

    //     $blockedByUsers = \App\Models\Block::where('blocked_id', $user->id)
    //         ->pluck('user_id')
    //         ->toArray();

    //     $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

    //     // Only valid friends (not blocked)
    //     $validFriendIds = array_diff($friendIds, $hiddenUsers);

    //     $friends = \App\Models\User::whereIn('id', $validFriendIds)->get();

    //     // Check receiver authorization
    //     $receiver = null;
    //     if ($receiver_id) {
    //         if (in_array($receiver_id, $validFriendIds)) {
    //             $receiver = \App\Models\User::find($receiver_id);
    //         } else {
    //             // Either not friend or blocked
    //             return abort(403, 'You cannot access chat with this user.');
    //         }
    //     }

    //     $agoraAppId = config('services.agora.app_id');

    //     return view('user.messages', [
    //         'user'          => $user,
    //         'notifications' => $notifications,
    //         'receiver'      => $receiver,
    //         'friends'       => $friends,
    //         'agoraAppId'    => $agoraAppId,
    //         'userId'        => $user->id,
    //         'hiddenUsers'   => $hiddenUsers,
    //     ]);
    // }

    public function messages($receiver_id = null)
    {
        abort_if(Auth::user()->role != 0, 403);

        $user          = Auth::user();
        $notifications = $user->unreadNotifications;

        /* ================= FRIENDS ================= */
        $friendIds = Friendship::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->get()
            ->map(fn($f) => $f->sender_id == $user->id ? $f->receiver_id : $f->sender_id)
            ->toArray();

        /* ================= BLOCKS ================= */
        $blocked     = Block::where('user_id', $user->id)->pluck('blocked_id')->toArray();
        $blockedBy   = Block::where('blocked_id', $user->id)->pluck('user_id')->toArray();
        $hiddenUsers = array_unique(array_merge($blocked, $blockedBy));

        $friendIds = array_diff($friendIds, $hiddenUsers);

        $friends = User::whereIn('id', $friendIds)->get();

        /* ================= ACCEPTED COUNSELORS ================= */
        $counselorIds = Message::where('sender_id', $user->id)
            ->where('status', 'accepted')
            ->pluck('receiver_id')
            ->toArray();

        $counselors = User::whereIn('id', $counselorIds)
            ->where('role', 1)
            ->get();

        /* ================= DATING CHAT USERS ================= */
        $datingUserIds = DatingMessage::where(function ($q) use ($user) {
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

        // Remove hidden users
        $datingUserIds = array_diff($datingUserIds, $hiddenUsers);

        $datingUsers = User::with('details') // eager load user_details
            ->whereIn('id', $datingUserIds)
            ->where('role', 0)
            ->get()
            ->map(function ($u) {
                // use photo1 from details if available
                $u->chat_type = 'dating';
                $u->image     = $u->details->photo1 ?? '0';
                return $u;
            });

        /* ================= MERGE ALL AS OBJECTS ================= */
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
            $chatUsers->push((object) [
                'id'         => $d->id,
                'name'       => $d->first_name . ' ' . $d->last_name,
                'image'      => $d->image,
                'UserStatus' => $d->UserStatus,
                'chat_type'  => 'dating',
            ]);
        }

        /* ================= RECEIVER CHECK ================= */
        $receiver         = null;
        $receiverChatType = null;

        $receiverType = request()->get('type');

        if ($receiver_id && $receiverType) {

            // find exact match: id + chat_type
            $receiverEntry = $chatUsers->first(function ($u) use ($receiver_id, $receiverType) {
                return (int) $u->id === (int) $receiver_id
                && $u->chat_type === $receiverType;
            });

            // if no exact match → block access
            abort_if(! $receiverEntry, 403);

            // load receiver properly
            if ($receiverType === 'dating') {
                $receiver             = User::with('details')->findOrFail($receiver_id);
                $receiver->chat_image = optional($receiver->details)->photo1;
            } else {
                $receiver             = User::findOrFail($receiver_id);
                $receiver->chat_image = $receiver->image;
            }

            $receiverChatType = $receiverType;
        }

        return view('user.messages', [
            'user'             => $user,
            'notifications'    => $notifications,
            'friends'          => $chatUsers,
            'receiver'         => $receiver,
            'hiddenUsers'      => $hiddenUsers,
            'receiverChatType' => $receiverChatType,
            'userId'           => $user->id,
        ]);
    }

    public function video()
    {
        $auth = Auth::user();

        // Optional: restrict route if only role=0 users can access
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;

        // Get all counselors (role = 1)
        $all_users = \App\Models\User::where('id', '!=', $auth->id)
            ->where('role', 1)
            ->get();

        // Attach friend count, friendship status, and rating
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

        // Fetch posts (in case you want videos from posts)
        $all_posts = \App\Models\Post::with(['user', 'likes', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch statuses (if needed)
        $statuses = \App\Models\Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->groupBy('user_id')
            ->map(fn($group) => collect($group));

        return view('user.video', [
            'user'          => $auth,
            'notifications' => $notifications,
            'all_users'     => $all_users,
            'all_posts'     => $all_posts,
            'statuses'      => $statuses,
        ]);
    }

    public function event()
    {
        $auth = Auth::user();

        // Only allow role 0
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        // Notifications
        $notifications = $auth->unreadNotifications;

        $blockedUsers = \App\Models\Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id') // only full user block
            ->pluck('blocked_id')
            ->toArray();

        $blockedByUsers = \App\Models\Block::where('blocked_id', $auth->id)
            ->whereNotNull('user_id') // only full user block
            ->pluck('user_id')
            ->toArray();

        $hiddenUsers = array_unique(array_merge($blockedUsers, $blockedByUsers));

        $all_users = \App\Models\User::where('id', '!=', $auth->id)
            ->whereNotIn('id', $hiddenUsers) // hide only fully blocked users
            ->with('ratingsReceived')
            ->inRandomOrder()
            ->get()
            ->map(function ($user) use ($auth) {
                // Friend count
                $friendCount = \App\Models\Friendship::where(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })->where('status', 'accepted')->count();
                $user->friend_count = $friendCount;

                // Friendship status
                $friendship = \App\Models\Friendship::where(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $auth->id)->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($auth, $user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $auth->id);
                })->first();

                $user->friendship_status = $friendship?->status;
                $user->friendship_sender = (int) ($friendship->sender_id ?? 0);

                // Average rating
                $user->average_rating = round($user->ratingsReceived->avg('rating') ?? 0, 1);

                return $user;
            });

        return view('user.event', [
            'user'          => $auth,
            'all_users'     => $all_users,
            'notifications' => $notifications,
        ]);
    }

    public function market()
    {
        $user          = Auth::user();
        $notifications = $user->unreadNotifications;
        return view('user.market', [
            'user'          => $user,
            'notifications' => $notifications,
        ]);
    }

    public function blog()
    {
        $user = Auth::user();
        abort_if($user->role != 0, 403, 'Unauthorized access');

        $notifications = $user->unreadNotifications;
        $appointments  = Message::with(['availability', 'sender', 'receiver'])
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Use the timezone you want for display/comparisons.
        // If your DB times are stored in UTC, set $tz = 'UTC' and then ->setTimezone('Asia/Kolkata') below.
        $tz  = 'Asia/Kolkata';
        $now = Carbon::now($tz);

        $appointments->each(function ($appointment) use ($tz, $now) {
            if (! $appointment->availability) {
                return;
            }

            $avail      = $appointment->availability;
            $date       = $avail->available_date ?? null; // expected 'YYYY-MM-DD'
            $start_time = $avail->start_time ?? null;     // expected 'HH:MM:SS'
            $end_time   = $avail->end_time ?? null;

            // Build full datetime strings and parse them in the chosen timezone.
            // If your DB stores UTC datetimes, parse with 'UTC' then ->setTimezone($tz).
            try {
                if ($date && $start_time) {
                    // Parse as local timezone (Asia/Kolkata)
                    $start = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $start_time, $tz);
                    $end   = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $end_time, $tz);
                } else {
                    // Fallback for other shapes (rare)
                    $start = Carbon::parse($start_time, $tz);
                    $end   = Carbon::parse($end_time, $tz);
                }
            } catch (\Exception $e) {
                // Fallback parsing if formatting differs
                $start = Carbon::parse(($date ? $date . ' ' : '') . $start_time, $tz);
                $end   = Carbon::parse(($date ? $date . ' ' : '') . $end_time, $tz);
            }

            // Save nicely formatted strings for Blade
            $appointment->availability->date      = $start->format('D, M d Y');
            $appointment->availability->startTime = $start->format('h:i A');
            $appointment->availability->endTime   = $end->format('h:i A');

            // Status flag for blade logic
            if ($now->greaterThan($end)) {
                $appointment->availability->statusFlag = 'past';
            } elseif ($now->between($start, $end)) {
                $appointment->availability->statusFlag = 'ongoing';
            } else {
                $appointment->availability->statusFlag = 'upcoming';
            }
        });

        $acceptedAppointment = $appointments->firstWhere('status', 'accepted');

        $ratings = Rating::where('user_id', $user->id)->get()->keyBy('counselor_id');
        return view('user.blog', [
            'user'                => $user,
            'notifications'       => $notifications,
            'appointments'        => $appointments,
            'acceptedAppointment' => $acceptedAppointment,
            'ratings'             => $ratings,
        ]);
    }

    public function timeline()
    {
        $auth = Auth::user();
        abort_if($auth->role != 0, 403, 'Unauthorized access');

        $notifications = $auth->unreadNotifications;

        // Get all users except logged-in user
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

        return view('user.timeline', [
            'user'            => $auth,
            'authFriendCount' => $authFriendCount,
            'all_users'       => $all_users,
            'all_posts'       => $all_posts, // now only user's posts
            'notifications'   => $notifications,
            'statuses'        => $statuses,
            'friends'         => $friends,
            'posts_count'     => $posts_count,
        ]);
    }

    public function contactUs()
    {
        $user          = Auth::user();
        $notifications = $user->unreadNotifications;
        return view('user.contact-us', [
            'user'          => $user,
            'notifications' => $notifications,
        ]);
    }

    public function components()
    {
        $user          = Auth::user();
        $notifications = $user->unreadNotifications;
        return view('user.components', [
            'user'          => $user,
            'notifications' => $notifications,
        ]);
    }

    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();

        // Read actual value sent from frontend
        $user->is_private = $request->input('is_private') ? 1 : 0;

        $user->save();

        return response()->json([
            'success'    => true,
            'is_private' => $user->is_private,
        ]);
    }
}
