<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Mute;
use App\Models\Tweet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiTweetController extends Controller
{
    /**
     * Get authenticated user's own tweets.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $tweets = Tweet::with('user')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Your thoughts fetched successfully.',
            'data'    => $tweets,
        ]);
    }

    /**
     * Create a new tweet.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'paragraph' => ['required', 'string', 'max:500'],
        ]);

        $tweet = Tweet::create([
            'user_id'   => $request->user()->id,
            'title'     => $validated['title'],
            'paragraph' => $validated['paragraph'],
        ]);

        $tweet->load('user');

        return response()->json([
            'status'  => true,
            'message' => 'Thought created successfully.',
            'data'    => $tweet,
        ], 201);
    }

    /**
     * Delete authenticated user's own tweet.
     */
    public function destroy(Request $request, Tweet $tweet): JsonResponse
    {
        if ($tweet->user_id !== $request->user()->id) {
            return response()->json([
                'status'  => false,
                'message' => 'You are not authorized to delete this thought.',
            ], 403);
        }

        $tweet->delete();

        return response()->json([
            'status'  => true,
            'message' => 'thought deleted successfully.',
        ]);
    }

    /**
     * Get tweets visible in the feed.
     *
     * Same visibility logic as web feed():
     * - Own tweets
     * - Public users' tweets
     * - Friends' tweets
     * - Hide blocked users
     * - Hide users who blocked auth user
     * - Hide muted users
     */
    public function feedTweets(Request $request): JsonResponse
    {
        $auth = $request->user();

        if ($auth->role != 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized access.',
            ], 403);
        }

        /*
         * Friends of authenticated user
         */
        $friends = $auth->friendsList()
            ->pluck('id')
            ->toArray();

        /*
         * Users blocked by auth user
         */
        $blockedUsers = Block::where('user_id', $auth->id)
            ->whereNotNull('blocked_id')
            ->pluck('blocked_id')
            ->toArray();

        /*
         * Users who blocked auth user
         */
        $blockedByUsers = Block::where('blocked_id', $auth->id)
            ->pluck('user_id')
            ->toArray();

        /*
         * Users muted by auth user
         */
        $mutedUsers = Mute::where('user_id', $auth->id)
            ->pluck('muted_user_id')
            ->toArray();

        /*
         * All users whose tweets should be hidden
         */
        $hiddenUsers = array_unique(array_merge(
            $blockedUsers,
            $blockedByUsers,
            $mutedUsers
        ));

        /*
         * Fetch visible tweets
         */
        $tweets = Tweet::with('user')

        /*
             * Hide blocked / muted users
             */
            ->whereNotIn('user_id', $hiddenUsers)

        /*
             * Own tweets OR public users OR friends
             */
            ->where(function ($q) use ($auth, $friends) {

                $q->where('user_id', $auth->id)

                    ->orWhereHas('user', function ($u) use ($friends) {

                        $u->where('is_private', 0)
                            ->orWhereIn('users.id', $friends);

                    });

            })

        /*
             * Exclude tweets from users who blocked auth
             */
            ->whereDoesntHave('user', function ($q) use ($auth) {

                $q->whereHas('blockedUsers', function ($q2) use ($auth) {

                    $q2->where(
                        'blocks.blocked_id',
                        $auth->id
                    );

                });

            })

        /*
             * Exclude tweets from users blocked by auth
             */
            ->whereDoesntHave('user', function ($q) use ($auth) {

                $q->whereHas('blockedByUsers', function ($q2) use ($auth) {

                    $q2->where(
                        'blocks.user_id',
                        $auth->id
                    );

                });

            })

            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Thoughts fetched successfully.',
            'data'    => $tweets,
        ]);
    }
}
