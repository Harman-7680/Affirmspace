<?php
namespace App\Http\Controllers;

use App\Models\JitsiRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JitsiRoomController extends Controller
{
    public function upgrade()
    {
        $user          = Auth::user();
        $notifications = $user->unreadNotifications;
        return view('user.upgrade', [
            'user'          => $user,
            'notifications' => $notifications,
        ]);
    }

    public function groups()
    {
        $user          = Auth::user();
        $notifications = $user->unreadNotifications;

        // Fetch rooms dynamically
        $rooms = JitsiRoom::withCount('users')->get();

        return view('user.groups', [
            'user'          => $user,
            'notifications' => $notifications,
            'rooms'         => $rooms,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_name'        => 'required|string|unique:jitsi_rooms,room_name',
            'description'      => 'nullable|string',
            'max_users'        => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $duration = (int) $request->duration_minutes;

        $startTime = now();
        $endTime   = now()->addMinutes($duration);

        // Generate Jitsi Room Link
        $roomLink = 'https://meet.jit.si/' . \Str::slug($request->room_name) . '-' . uniqid();

        $room = JitsiRoom::create([
            'room_name'        => $request->room_name,
            'created_by'       => auth()->id(),
            'description'      => $request->description,
            'max_users'        => $request->max_users,
            'duration_minutes' => $duration,
            'start_time'       => $startTime,
            'end_time'         => $endTime,
            'jitsi_link'       => $roomLink,
        ]);

        // Add creator as admin
        $room->users()->attach(auth()->id(), ['is_admin' => true]);

        return redirect()->route('groups')->with('success', 'Room created successfully!');
    }

    public function join(JitsiRoom $room)
    {
        $alreadyJoined = $room->users()->where('user_id', auth()->id())->exists();

        if (! $alreadyJoined) {
            // Check max users
            if ($room->users()->count() >= $room->max_users) {
                return redirect()->back()->with('error', 'Room is full!');
            }
            $room->users()->attach(auth()->id(), ['is_admin' => false]);
        }

        return redirect()->to($room->jitsi_link);
    }

}
