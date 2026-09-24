<?php
namespace App\Http\Controllers;

use App\Mail\AdminBroadcastMail;
use App\Models\AdminContact;
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

        $newsletterEmails = AdminContact::where('type', 'newsletter')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->pluck('email')
            ->unique()
            ->values();

        return view('admin.send_message', compact('users', 'newsletterEmails'));
    }

    public function sendMessage(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'message'   => 'required|string',
            'user_type' => 'required|in:counselor,counselee,newsletter',
        ]);

        $message = $request->message;
        $role    = $request->user_type === 'counselor' ? 1 : 0;

        if ($request->user_type === 'newsletter') {

            AdminContact::where('type', 'newsletter')
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->select('email')
                ->distinct()
                ->chunk(5, function ($subscribers) use ($message) {

                    foreach ($subscribers as $subscriber) {

                        try {
                            Mail::to($subscriber->email)->send(
                                new AdminBroadcastMail(
                                    $message,
                                    'Subscriber'
                                )
                            );

                            sleep(1);

                        } catch (\Throwable $e) {

                            Log::error([
                                'email' => $subscriber->email,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                });

            return response()->json([
                'success' => true,
                'message' => 'Newsletter messages sent successfully',
            ]);
        }

        User::where('role', $role)
            ->whereNotNull('email')
            ->chunk(5, function ($users) use ($message) {

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

                    try {

                        Mail::to($user->email)->send(
                            new AdminBroadcastMail(
                                $message,
                                $user->first_name ?? 'User'
                            )
                        );

                        // optional delay
                        sleep(1);

                    } catch (\Throwable $e) {

                        \Log::error([
                            'user_id' => $user->id,
                            'email'   => $user->email,
                            'error'   => $e->getMessage(),
                        ]);
                    }
                }
            });

        return response()->json([
            'success' => true,
            'message' => 'Messages sent successfully',
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
