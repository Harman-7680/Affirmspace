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

        // Get all users of selected type
        $users = User::where('role', $role)->get();

        foreach ($users as $user) {

            // Send Firebase notifications using your existing service
            $tokens = UserDevice::where('user_id', $user->id)->pluck('device_token');

            foreach ($tokens as $token) {
                try {
                    app(FirebaseNotificationService::class)->send(
                        $token,
                        'Message from Admin',
                        $message,
                        [
                            'type' => 'admin_message',
                        ]
                    );
                } catch (\Throwable $e) {
                    Log::error("Firebase Admin Push Error for user {$user->id}: " . $e->getMessage());
                }
            }

            Mail::to($user->email)->send(
                new AdminBroadcastMail($message, $user->first_name ?? 'User')
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully',
        ]);
    }
}
