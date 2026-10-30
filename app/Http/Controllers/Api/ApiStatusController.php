<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\Status;
use App\Models\StatusView;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiStatusController extends Controller
{
    // Create a new status
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Delete statuses older than 24 hours
        $user->statuses()
            ->where('created_at', '<', now()->subDay())
            ->delete();

        // Store uploaded image
        $imagePath = $request->file('image')->store('statuses', 'public');

        $status = $user->statuses()->create([
            'image'   => $imagePath,
            'caption' => $request->caption,
        ]);

        $this->statusDebug('API STATUS CREATED: ' . $status->id);

        // Get accepted friends
        $friendships = Friendship::where('status', 'accepted')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->get();

        $friendIds = $friendships->map(function ($friendship) use ($user) {
            return $friendship->sender_id == $user->id
                ? $friendship->receiver_id
                : $friendship->sender_id;
        })->unique();

        $this->statusDebug('API FRIENDS FOUND: ' . $friendIds->count());

        // Send notification to accepted friends
        foreach ($friendIds as $friendId) {
            $this->sendStatusNotification(
                $friendId,
                trim($user->first_name . ' ' . $user->last_name),
                'Added a new status',
                [
                    'type'      => 'new_status',
                    'sender_id' => (string) $user->id,
                    'status_id' => (string) $status->id,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Status created successfully!',
            'status'  => [
                'id'         => $status->id,
                'image'      => asset('storage/' . $status->image),
                'user'       => [
                    'id'         => $user->id,
                    'first_name' => $user->first_name,
                    'last_name'  => $user->last_name,
                    'image'      => $user->image
                        ? asset('storage/' . $user->image)
                        : asset('images/avatars/avatar-1.jpg'),
                ],
                'created_at' => $status->created_at->toDateTimeString(),
            ],
        ], 201);
    }

    // Fetch all statuses from last 24 hours
    public function index()
    {
        $statuses = Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->map(function ($status) {
                return [
                    'id'         => $status->id,
                    'image'      => asset('storage/' . $status->image),
                    'user'       => [
                        'id'         => $status->user->id,
                        'first_name' => $status->user->first_name,
                        'last_name'  => $status->user->last_name,
                        'image'      => $status->user->image ? asset('storage/' . $status->user->image) : asset('images/avatars/avatar-1.jpg'),
                    ],
                    'created_at' => $status->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'success'  => true,
            'statuses' => $statuses,
            'count'    => $statuses->count(),
        ]);
    }

    public function markStatusViewed($statusId)
    {
        $status = Status::with('user')
            ->where('id', $statusId)
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if (! $status) {
            return response()->json([
                'success' => false,
                'message' => 'Status not found or expired.',
            ], 404);
        }

        $viewer = Auth::user();

        // Create view record
        $view = StatusView::firstOrCreate([
            'status_id' => $status->id,
            'viewer_id' => $viewer->id,
        ]);

        $this->statusDebug(
            'API STATUS VIEWED: Status ID ' . $status->id .
            ' | Viewer ID: ' . $viewer->id .
            ' | New View: ' . ($view->wasRecentlyCreated ? 'YES' : 'NO')
        );

        // Notify owner only on first view
        if (
            $view->wasRecentlyCreated &&
            $status->user_id != $viewer->id
        ) {
            $viewerName = trim(
                $viewer->first_name . ' ' . $viewer->last_name
            );

            $this->sendStatusNotification(
                $status->user_id,
                $viewerName,
                'Viewed your status',
                [
                    'type'      => 'status_view',
                    'sender_id' => (string) $viewer->id,
                    'status_id' => (string) $status->id,
                ]
            );
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'status_id' => 'required|integer|exists:statuses,id',
        ]);

        $user = Auth::user();

        $status = Status::where('id', $request->status_id)
            ->where('user_id', $user->id)
            ->first();

        if (! $status) {
            return response()->json([
                'success' => false,
                'message' => 'Status not found or you are not authorized to delete it.',
            ], 404);
        }

        // Delete image
        if ($status->image) {
            $imagePath = public_path('storage/' . $status->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Status deleted successfully.',
        ]);
    }

    private function sendStatusNotification($userId, $title, $body, array $data = [])
    {
        $tokens = UserDevice::where('user_id', $userId)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token')
            ->unique();

        $this->statusDebug(
            "API USER {$userId} | DEVICE TOKENS: " . $tokens->count()
        );

        if ($tokens->isEmpty()) {
            $this->statusDebug("API NO DEVICE TOKEN FOR USER {$userId}");
            return;
        }

        foreach ($tokens as $token) {
            try {
                app(FirebaseNotificationService::class)->send(
                    $token,
                    $title,
                    $body,
                    $data
                );

                $this->statusDebug(
                    "API FIREBASE SEND COMPLETED FOR USER {$userId}"
                );

            } catch (\Throwable $e) {
                $this->statusDebug(
                    "API FIREBASE ERROR FOR USER {$userId}: " . $e->getMessage()
                );
            }
        }
    }

    private function statusDebug($message)
    {
        file_put_contents(
            storage_path('logs/status-debug.log'),
            '[' . now() . '] ' . $message . PHP_EOL,
            FILE_APPEND
        );
    }
}
