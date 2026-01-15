<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentStatusMail;
use App\Models\CounselorAvailability;
use App\Models\Message;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApiCounselorAvailabilityController extends Controller
{
    public function __construct()
    {
        // Auto-delete expired availabilities
        CounselorAvailability::where(function ($query) {
            $query->where('available_date', '<', Carbon::today())
                ->orWhere(function ($sub) {
                    $sub->where('available_date', Carbon::today())
                        ->where('start_time', '<', Carbon::now()->format('H:i:s'));
                });
        })->delete();
    }

    public function store(Request $request)
    {
        $request->validate([
            'available_date' => 'required|date|after_or_equal:today',
            'start_time'     => 'required|date_format:H:i',
            'end_time'       => 'required|date_format:H:i|after:start_time',
        ]);

        $startDateTime = Carbon::parse($request->available_date . ' ' . $request->start_time);
        if ($startDateTime->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a future date and time.',
            ], 422);
        }

        $availability = CounselorAvailability::create([
            'counselor_id'   => Auth::id(),
            'available_date' => $request->available_date,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Availability saved.',
            'data'    => $availability,
        ], 201);
    }

    public function destroy($id)
    {
        $availability = CounselorAvailability::where('id', $id)
            ->where('counselor_id', auth()->id())
            ->firstOrFail();

        $availability->delete();

        return response()->json([
            'success' => true,
            'message' => 'Availability deleted successfully.',
        ]);
    }

    public function index()
    {
        $availabilities = CounselorAvailability::where('counselor_id', auth()->id())->get();

        return response()->json([
            'success' => true,
            'data'    => $availabilities,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $allowedStatuses = ['accepted', 'rejected'];
        $status          = $request->status;

        // Validate input
        if (! in_array($status, $allowedStatuses)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status value.',
            ], 422);
        }

        $message = Message::findOrFail($id);

        // Check if the logged-in user is the receiver
        if (Auth::id() != $message->receiver_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        // Update status
        $message->status = $status;
        $message->save();

        // Send email notification
        Mail::to($message->email)->send(new AppointmentStatusMail($message, $status));

        $this->sendFirebaseSafe(
            $message->sender_id,
            'Appointment Update',
            "Your appointment has been {$status}",
            [
                'type'       => 'appointment_status',
                'status'     => $status,
                'message_id' => (string) $message->id,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => "Appointment {$status} successfully, and email sent.",
            'data' => $message,
        ], 200);
    }

    private function sendFirebaseSafe($userId, $title, $body, array $data = [])
    {
        $tokens = UserDevice::where('user_id', $userId)
            ->whereNotNull('device_token')
            ->where('device_token', '!=', '')
            ->pluck('device_token');

        if ($tokens->isEmpty()) {
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
            } catch (\Throwable $e) {
                Log::warning(
                    "Firebase appointment push skipped (user {$userId}): " . $e->getMessage()
                );
            }
        }
    }
}
