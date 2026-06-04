<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JitsiRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiJitsiRoomController extends Controller
{
    public function rooms()
    {
        $rooms = JitsiRoom::withCount('users')

            ->where('end_time', '>', now())

            ->latest()

            ->get();

        return response()->json([

            'status' => true,

            'rooms'  => $rooms,
        ]);
    }

    public function create(Request $request)
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

        // CREATOR JOIN
        $room->users()->attach(auth()->id(), [

            'is_admin' => true,
        ]);

        return response()->json([

            'status'  => true,

            'message' => 'Room created successfully',

            'room'    => $room,
        ]);
    }

    public function join(JitsiRoom $room)
    {
        if (now()->greaterThan($room->end_time)) {

            return response()->json([

                'status'  => false,

                'message' => 'Room expired',
            ]);
        }

        if ($room->users()->count() >= $room->max_users) {

            return response()->json([

                'status'  => false,

                'message' => 'Room full',
            ]);
        }

        $alreadyJoined = $room->users()

            ->where('user_id', auth()->id())

            ->exists();

        if (! $alreadyJoined) {

            $room->users()->attach(auth()->id(), [

                'is_admin' => false,
            ]);
        }

        // ADMIN / RANDOM USER
        $isAdmin = $room->created_by == auth()->id();

        $displayName = $isAdmin
            ? 'Admin'
            : 'User-' . rand(1000, 9999);

        $jwt = \App\Services\JitsiService::generateToken(

            $room->room_code,

            auth()->user(),

            $displayName
        );

        // WEBVIEW URL
        $webviewUrl = url('/group-call-page') . '?' . http_build_query([

            'room_name'  => $room->room_code,

            'jwt'        => $jwt,

            'expires_at' => strtotime($room->end_time),
        ]);

        return response()->json([

            'status'      => true,

            'webview_url' => $webviewUrl,

            'expires_at'  => strtotime($room->end_time),
        ]);
    }
}
