<?php
namespace App\Http\Controllers;

use App\Mail\AdminBroadcastMail;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminMessageController extends Controller
{
    public function showSendMessageForm()
    {
        $users = User::all();
        return view('admin.send_message', compact('users'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message'   => 'required|string',
            'user_type' => 'required|in:counselor,counselee',
        ]);

        $message = $request->message;
        $role    = $request->user_type === 'counselor' ? 1 : 0;

        // Get users by role
        $users = User::where('role', $role)->get();

        foreach ($users as $user) {

            // SAFE Firebase push (won't crash)
            $this->sendFirebaseSafe(
                $user->id,
                'Message from Admin',
                $message,
                [
                    'type' => 'admin_message',
                ]
            );

            // Email ALWAYS works
            try {
                Mail::to($user->email)->send(
                    new AdminBroadcastMail($message, $user->first_name ?? 'User')
                );
            } catch (\Throwable $e) {
                Log::error("Admin email failed for user {$user->id}: " . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
        ]);
    }

    /**
     * SAFE Firebase sender (shared logic)
     */
    private function sendFirebaseSafe($userId, $title, $body, array $data = [])
    {
        $tokens = UserDevice::where('user_id', $userId)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token');

        if ($tokens->isEmpty()) {
            return; // No device → silently skip
        }

        foreach ($tokens as $token) {
            try {
                app(FirebaseNotificationService::class)->send(
                    $token,
                    $title,
                    $body,
                    $data
                );
            } catch (\Throwable $e) {
                Log::warning(
                    "Firebase admin push skipped (user {$userId}): " . $e->getMessage()
                );
            }
        }
    }
}
