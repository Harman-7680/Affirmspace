<?php
namespace App\Http\Controllers;

use App\Models\JitsiRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $rooms = JitsiRoom::withCount('users')
            ->where('end_time', '>', now())
            ->latest()
            ->get();

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

        $endTime = now()->addMinutes($duration);

        // EXACT SAME STYLE AS 1-to-1
        $roomCode =
        config('services.jitsi.app_id') .
        '/AffirmSpaceGroup_' .
        Str::random(15);

        $room = JitsiRoom::create([

            'room_name'        => $request->room_name,

            'room_code'        => $roomCode,

            'created_by'       => auth()->id(),

            'description'      => $request->description,

            'max_users'        => $request->max_users,

            'duration_minutes' => $duration,

            'start_time'       => $startTime,

            'end_time'         => $endTime,
        ]);

        // creator join
        $room->users()->attach(auth()->id(), [

            'is_admin' => true,
        ]);

        return redirect()
            ->route('groups')
            ->with('success', 'Room created successfully!');
    }

    public function join(JitsiRoom $room)
    {
        if (now()->greaterThan($room->end_time)) {

            return response()->json([
                'error' => 'Room expired',
            ], 400);
        }

        if ($room->users()->count() >= $room->max_users) {

            return response()->json([
                'error' => 'Room full',
            ], 400);
        }

        $alreadyJoined = $room->users()
            ->where('user_id', auth()->id())
            ->exists();

        if (! $alreadyJoined) {

            $room->users()->attach(auth()->id(), [

                'is_admin' => false,
            ]);
        }

        $isAdmin = $room->created_by == auth()->id();

        $displayName = $isAdmin
            ? 'Admin'
            : 'User-' . rand(1000, 9999);

        $jwt = \App\Services\JitsiService::generateToken(
            $room->room_code,
            auth()->user(),
            $displayName
        );

        return response()->json([

            'success'    => true,

            'room_name'  => $room->room_code,

            'jwt'        => $jwt,

            'expires_at' => $room->created_at
                ->addMinutes($room->duration_minutes)
                ->timestamp,
        ]);
    }

}
