<?php
namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\Status;
use App\Models\StatusView;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StatusController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        // Delete statuses older than 24 hours
        $user->statuses()
            ->where('created_at', '<', now()->subDay())
            ->delete();

        // Store new status
        $imagePath = $request->file('image')->store('statuses', 'public');

        $status = $user->statuses()->create([
            'image'   => $imagePath,
            'caption' => $request->caption,
        ]);

        $this->statusDebug('STATUS CREATED: ' . $status->id);

        // Get accepted friendships
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

        $this->statusDebug('FRIENDS FOUND: ' . $friendIds->count());

        // Send notification to friends
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
        ]);
    }

    public function index()
    {
        $statuses = Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get();

        return redirect()->route('feed')->with([
            'statuses'     => $statuses,
            'status_count' => $statuses->count(),
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

        $viewer = auth()->user();

        // Create view record
        $view = StatusView::firstOrCreate([
            'status_id' => $status->id,
            'viewer_id' => $viewer->id,
        ]);

        $this->statusDebug(
            'STATUS VIEWED: Status ID ' . $status->id .
            ' | Viewer ID: ' . $viewer->id .
            ' | New View: ' . ($view->wasRecentlyCreated ? 'YES' : 'NO')
        );

        // Notify status owner only on first view
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

        // Existing fully viewed calculation
        $userStatusIds = Status::where('user_id', $status->user_id)
            ->where('created_at', '>=', now()->subDay())
            ->pluck('id');

        $viewedCount = StatusView::where('viewer_id', $viewer->id)
            ->whereIn('status_id', $userStatusIds)
            ->count();

        $isFullyViewed = $userStatusIds->isNotEmpty()
        && $viewedCount >= $userStatusIds->count();

        return response()->json([
            'success'         => true,
            'is_fully_viewed' => $isFullyViewed,
        ]);
    }

    public function destroy(Request $request)
    {
        $status = Status::where('id', $request->status_id)
            ->where('user_id', auth()->id())
            ->first();

        if (! $status) {
            return response()->json([
                'success' => false,
                'message' => 'Status not found or unauthorized.',
            ], 404);
        }

        if ($status->image) {
            Storage::disk('public')->delete($status->image);
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
            "USER {$userId} | DEVICE TOKENS: " . $tokens->count()
        );

        if ($tokens->isEmpty()) {
            $this->statusDebug("NO DEVICE TOKEN FOR USER {$userId}");
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

                $this->statusDebug("FIREBASE SEND COMPLETED FOR USER {$userId}");

            } catch (\Throwable $e) {

                $this->statusDebug(
                    "FIREBASE ERROR FOR USER {$userId}: " . $e->getMessage()
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
