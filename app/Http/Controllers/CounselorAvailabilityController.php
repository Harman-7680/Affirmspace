<?php
namespace App\Http\Controllers;

use App\Mail\AppointmentStatusMail;
use App\Models\CounselorAvailability;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CounselorAvailabilityController extends Controller
{
    public function __construct()
    {
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
            return back()->withErrors(['start_time' => 'Please select a future date and time.'])->withInput();
        }

        CounselorAvailability::create([
            'counselor_id'   => Auth::id(),
            'available_date' => $request->available_date,
            'start_time'     => $request->start_time,
            'end_time'       => $request->end_time,
        ]);

        return back()->with('success', 'Availability saved.');
    }

    public function destroy($id)
    {
        $availability = CounselorAvailability::where('id', $id)
            ->where('counselor_id', auth()->id())
            ->firstOrFail();

        $availability->delete();

        return back()->with('success', 'Availability deleted successfully.');
    }

    public function updateStatus(Request $request, $id, $status)
    {
        $allowedStatuses = ['accepted', 'rejected'];

        if (! in_array($status, $allowedStatuses)) {
            return back()->withErrors(['Invalid status']);
        }

        $message = Message::findOrFail($id);

        // Check authorized user
        if (Auth::id() != $message->receiver_id) {
            abort(403, 'Unauthorized action.');
        }

        $message->status = $status;
        $message->save();

        Mail::to($message->email)->send(new AppointmentStatusMail($message, $status));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Appointment {$status} and email sent.",
            ]);
        }

        return back()->with('success', "Appointment {$status} successfully, and email sent.");
    }
}
