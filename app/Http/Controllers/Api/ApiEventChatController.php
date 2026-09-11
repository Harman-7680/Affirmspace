<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiEventChatController extends Controller
{
    /**
     * Event Chats List
     *
     * Shows:
     * 1. Messages on My Events
     * 2. Events I Messaged
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        abort_if($user->role != 0, 403, 'Unauthorized access');

        $chats = EventChat::with([
            'event',
            'sender',
        ])
            ->whereHas('event', function ($q) {
                $q->where('status', 'approved');
            })
            ->where(function ($q) use ($user) {

                // I am event owner
                $q->whereHas('event', function ($eventQuery) use ($user) {
                    $eventQuery->where('user_id', $user->id);
                })

                // OR I have messaged an event
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

            /*
            |--------------------------------------------------------------------------
            | CASE 1: I AM EVENT OWNER
            |--------------------------------------------------------------------------
            */

            if ((int) $event->user_id === (int) $user->id) {

                /*
                 * For owner:
                 *
                 * visitor first message:
                 * sender_id = visitor
                 * conversation_user_id = owner
                 *
                 * owner reply:
                 * sender_id = owner
                 * conversation_user_id = visitor
                 *
                 * Therefore conversation user is conversation_user_id
                 * when owner sent the message.
                 */

                if ((int) $chat->sender_id === (int) $user->id) {
                    $otherUserId = (int) $chat->conversation_user_id;
                } else {
                    $otherUserId = (int) $chat->sender_id;
                }

                if (! $otherUserId || $otherUserId === (int) $user->id) {
                    continue;
                }

                $key = $event->id . '_' . $otherUserId;

                if (! $myEventConversations->has($key)) {

                    $otherUser = User::find($otherUserId);

                    $myEventConversations->put($key, [
                        'key'               => $key,

                        'event_id'          => $event->id,
                        'event_name'        => $event->name,
                        'event_image'       => $event->image,

                        'event_owner_id'    => $event->user_id,

                        'other_user_id'     => $otherUserId,
                        'other_user'        => $otherUser,

                        'last_message'      => $chat->message,
                        'last_message_time' => $chat->created_at,

                        'sender_id'         => $chat->sender_id,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | CASE 2: I AM VISITOR
            |--------------------------------------------------------------------------
            */

            else {

                // Only conversations where I actually messaged
                if ((int) $chat->sender_id !== (int) $user->id) {

                    /*
                     * Owner's reply will also be part of this conversation.
                     * So don't skip it.
                     *
                     * But we need to identify the conversation through
                     * conversation_user_id.
                     */

                    if ((int) $chat->conversation_user_id !== (int) $user->id) {
                        continue;
                    }
                }

                $otherUserId = (int) $event->user_id;

                if ($otherUserId === (int) $user->id) {
                    continue;
                }

                $key = $event->id . '_' . $otherUserId;

                if (! $otherEventConversations->has($key)) {

                    $otherUser = User::find($otherUserId);

                    $otherEventConversations->put($key, [
                        'key'               => $key,

                        'event_id'          => $event->id,
                        'event_name'        => $event->name,
                        'event_image'       => $event->image,

                        'event_owner_id'    => $event->user_id,

                        'other_user_id'     => $otherUserId,
                        'other_user'        => $otherUser,

                        'last_message'      => $chat->message,
                        'last_message_time' => $chat->created_at,

                        'sender_id'         => $chat->sender_id,
                    ]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Selected Conversation
        |--------------------------------------------------------------------------
        */

        $selectedEvent    = null;
        $selectedUser     = null;
        $selectedMessages = collect();

        $eventId     = $request->get('event_id');
        $otherUserId = $request->get('user_id');

        if ($eventId && $otherUserId) {

            $selectedEvent = Event::where('id', $eventId)
                ->where('status', 'approved')
                ->firstOrFail();

            $selectedUser = User::findOrFail($otherUserId);

            $authId      = (int) $user->id;
            $otherUserId = (int) $otherUserId;

            /*
            |--------------------------------------------------------------------------
            | Owner Conversation
            |--------------------------------------------------------------------------
            */

            if ((int) $selectedEvent->user_id === $authId) {

                $allowed = EventChat::where('event_id', $selectedEvent->id)
                    ->where(function ($q) use ($authId, $otherUserId) {

                        $q->where(function ($q) use ($authId, $otherUserId) {
                            $q->where('sender_id', $otherUserId)
                                ->where('conversation_user_id', $authId);
                        })

                            ->orWhere(function ($q) use ($authId, $otherUserId) {
                                $q->where('sender_id', $authId)
                                    ->where('conversation_user_id', $otherUserId);
                            });
                    })
                    ->exists();

            }

            /*
            |--------------------------------------------------------------------------
            | Visitor Conversation
            |--------------------------------------------------------------------------
            */

            else {

                if ($otherUserId !== (int) $selectedEvent->user_id) {
                    abort(403, 'Invalid conversation.');
                }

                $allowed = EventChat::where('event_id', $selectedEvent->id)
                    ->where(function ($q) use ($authId, $otherUserId) {

                        $q->where('sender_id', $authId)
                            ->where('conversation_user_id', $otherUserId);

                    })
                    ->exists();
            }

            abort_if(! $allowed, 403, 'Conversation not found.');

            /*
            |--------------------------------------------------------------------------
            | EXACT CONVERSATION
            |--------------------------------------------------------------------------
            */

            $selectedMessages = EventChat::with('sender')
                ->where('event_id', $selectedEvent->id)
                ->where(function ($q) use ($authId, $otherUserId) {

                    $q->where(function ($q) use ($authId, $otherUserId) {

                        $q->where('sender_id', $authId)
                            ->where('conversation_user_id', $otherUserId);

                    })
                        ->orWhere(function ($q) use ($authId, $otherUserId) {

                            $q->where('sender_id', $otherUserId)
                                ->where('conversation_user_id', $authId);

                        });
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return response()->json([
            'success'                => true,

            'my_event_conversations' => $myEventConversations
                ->values(),

            'events_i_messaged'      => $otherEventConversations
                ->values(),

            'selected_event'         => $selectedEvent,

            'selected_user'          => $selectedUser,

            'messages'               => $selectedMessages,
        ]);
    }

    /**
     * Send message inside existing Event conversation
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        abort_if($user->role != 0, 403, 'Unauthorized access');

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

        /*
        |--------------------------------------------------------------------------
        | Cannot message yourself
        |--------------------------------------------------------------------------
        */

        abort_if(
            $authId === $otherUserId,
            403,
            'You cannot message yourself.'
        );

        /*
        |--------------------------------------------------------------------------
        | CASE 1: I AM EVENT OWNER
        |--------------------------------------------------------------------------
        */

        if ((int) $event->user_id === $authId) {

            $allowed = EventChat::where('event_id', $event->id)
                ->where(function ($q) use ($authId, $otherUserId) {

                    $q->where(function ($q) use ($authId, $otherUserId) {

                        $q->where('sender_id', $otherUserId)
                            ->where('conversation_user_id', $authId);

                    })
                        ->orWhere(function ($q) use ($authId, $otherUserId) {

                            $q->where('sender_id', $authId)
                                ->where('conversation_user_id', $otherUserId);

                        });
                })
                ->exists();

            abort_if(
                ! $allowed,
                403,
                'This conversation does not exist.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CASE 2: I AM VISITOR
        |--------------------------------------------------------------------------
        */

        else {

            // Visitor can only talk to event owner
            abort_if(
                $otherUserId !== (int) $event->user_id,
                403,
                'You can only message the event owner.'
            );

            // Visitor must already have started conversation
            $allowed = EventChat::where('event_id', $event->id)
                ->where('sender_id', $authId)
                ->where('conversation_user_id', $otherUserId)
                ->exists();

            abort_if(
                ! $allowed,
                403,
                'Please start the conversation from the event.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE MESSAGE
        |--------------------------------------------------------------------------
        */

        $chat = EventChat::create([
            'event_id'             => $event->id,
            'sender_id'            => $authId,
            'conversation_user_id' => $otherUserId,
            'message'              => $request->message,
        ]);

        $chat->load('sender');

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data'    => $chat,
        ]);
    }
}
