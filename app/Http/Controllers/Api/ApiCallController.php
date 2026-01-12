<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\JitsiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiCallController extends Controller
{
    public function startCall(Request $request)
    {
        $receiverId = $request->receiver_id;
        $sender     = Auth::user();

        $roomName = config('services.jitsi.app_id') .
        '/AffirmSpaceCall_' .
        min($sender->id, $receiverId) . '_' .
        max($sender->id, $receiverId);

        $callId = 'call_' . $sender->id . '_' . $receiverId . '_' . time();
        $jwt    = JitsiService::generateToken($roomName, $sender);

        return response()->json([
            'call_id'     => $callId,
            'room_name'   => $roomName,
            'jwt'         => $jwt,
            'sender'      => [
                'id'   => $sender->id,
                'name' => $sender->first_name,
            ],
            'receiver_id' => $receiverId,
        ]);
    }
}
