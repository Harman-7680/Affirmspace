<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventChatController extends Controller
{
    public function index(Request $request)
    {

        abort_if(Auth::user()->role != 0, 403);
        $user          = Auth::user();
        $notifications = $user->unreadNotifications;
        $myEvents      = Event::where('user_id', $user->id)
            ->where('status', 'approved')
            ->get();
        $chats = EventChat::with([
            'event',
            'sender',
        ])
            ->whereHas('event', function ($q) {
                $q->where('status', 'approved');
            })
            ->where(function ($q) use ($user) {

                $q->whereHas('event', function ($eventQuery) use ($user) {
                    $eventQuery->where('user_id', $user->id);
                })
                    ->orWhere('sender_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $myEventConversations    = collect();
        $otherEventConversations = collect();
        foreach ($chats as $chat) {

            $event = $chat->event;

            if (! $event) {
                continue;
            }

            if ((int) $event->user_id === (int) $user->id) {

                $otherUserId = (int) $chat->sender_id;
                if ($otherUserId === (int) $user->id) {
                    continue;
                }

                $key = $event->id . '_' . $otherUserId;
                if (! $myEventConversations->has($key)) {

                    $myEventConversations->put($key, [

                        'key'               => $key,
                        'event_id'          => $event->id,
                        'event_name'        => $event->name,
                        'event_image'       => $event->image,
                        'event_owner_id'    => $event->user_id,
                        'other_user_id'     => $otherUserId,
                        'last_message'      => $chat->message,
                        'last_message_time' => $chat->created_at,
                        'sender_id'         => $chat->sender_id,

                    ]);
                }
            } else {
                if ((int) $chat->sender_id !== (int) $user->id) {
                    continue;
                }
                $otherUserId = (int) $event->user_id;
                if ($otherUserId === (int) $user->id) {
                    continue;
                }
                $key = $event->id . '_' . $otherUserId;
                if (! $otherEventConversations->has($key)) {

                    $otherEventConversations->put($key, [

                        'key'               => $key,
                        'event_id'          => $event->id,
                        'event_name'        => $event->name,
                        'event_image'       => $event->image,
                        'event_owner_id'    => $event->user_id,
                        'other_user_id'     => $otherUserId,
                        'last_message'      => $chat->message,
                        'last_message_time' => $chat->created_at,
                        'sender_id'         => $chat->sender_id,

                    ]);
                }
            }
        }

        $selectedEvent    = null;
        $selectedUser     = null;
        $selectedMessages = collect();
        $eventId          = $request->get('event_id');
        $otherUserId      = $request->get('user_id');

        if ($eventId && $otherUserId) {
            $selectedEvent = Event::where('id', $eventId)
                ->where('status', 'approved')
                ->firstOrFail();

            $selectedUser = \App\Models\User::findOrFail($otherUserId);
            $allowed      = false;

            if ((int) $selectedEvent->user_id === (int) $user->id) {

                if ((int) $otherUserId === (int) $user->id) {
                    abort(403);
                }

                $allowed = EventChat::where('event_id', $selectedEvent->id)
                    ->where('sender_id', $otherUserId)
                    ->exists();
            } else {

                if ((int) $otherUserId !== (int) $selectedEvent->user_id) {
                    abort(403);
                }

                $allowed = EventChat::where('event_id', $selectedEvent->id)
                    ->where('sender_id', $user->id)
                    ->exists();
            }
            abort_if(! $allowed, 403);

            $selectedMessages = EventChat::with('sender')
                ->where('event_id', $selectedEvent->id)
                ->where(function ($q) use ($user, $otherUserId) {

                    // My messages to selected user
                    $q->where(function ($q) use ($user, $otherUserId) {
                        $q->where('sender_id', $user->id)
                            ->where('conversation_user_id', $otherUserId);
                    })

                    // Selected user's messages to me
                        ->orWhere(function ($q) use ($user, $otherUserId) {
                            $q->where('sender_id', $otherUserId)
                                ->where('conversation_user_id', $user->id);
                        });

                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('user.event-chats', [
            'user'                    => $user,
            'notifications'           => $notifications,
            'myEvents'                => $myEvents,
            'selectedEvent'           => $selectedEvent,
            'selectedUser'            => $selectedUser,
            'selectedMessages'        => $selectedMessages,
            'myEventConversations'    => $myEventConversations->values(),
            'otherEventConversations' => $otherEventConversations->values(),
        ]);
    }

    public function sendMessage(Request $request)
    {
        abort_if(Auth::user()->role != 0, 403);

        $user = Auth::user();

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'user_id'  => 'required|exists:users,id',
            'message'  => 'required|string|max:5000',
        ]);

        $event = Event::where('id', $request->event_id)
            ->where('status', 'approved')
            ->firstOrFail();

        $authId      = (int) $user->id;
        $otherUserId = (int) $request->user_id;

        // Cannot message yourself
        abort_if($authId === $otherUserId, 403);
        if ((int) $event->user_id === $authId) {

            // Selected user must have messaged this event
            $allowed = EventChat::where('event_id', $event->id)
                ->where('sender_id', $otherUserId)
                ->exists();

            abort_if(! $allowed, 403);
        } else {

            // Visitor can only talk to event owner
            abort_if(
                $otherUserId !== (int) $event->user_id,
                403
            );

            // Visitor must have already messaged this event
            $allowed = EventChat::where('event_id', $event->id)
                ->where('sender_id', $authId)
                ->exists();

            abort_if(! $allowed, 403);
        }

        EventChat::create([
            'event_id'             => $event->id,
            'sender_id'            => $authId,
            'conversation_user_id' => $otherUserId,
            'message'              => $request->message,
        ]);

        return redirect()->route('events.chats', [
            'event_id' => $event->id,
            'user_id'  => $otherUserId,
        ])->with('success', 'Message sent successfully.');
    }
}
