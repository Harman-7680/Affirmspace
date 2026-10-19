<?php

use App\Models\JitsiRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{room}', function ($user, $room) {
    return true;
});

Broadcast::channel('group-chat.{roomId}', function ($user, $roomId) {

    $room = JitsiRoom::find($roomId);

    if (! $room) {
        return false;
    }

    return $room->users()
        ->where('users.id', $user->id)
        ->exists();
});
