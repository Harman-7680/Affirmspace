<?php
namespace App\Console\Commands;

use App\Models\ChatMessage;
use App\Models\FriendChatGroupMessage;
use App\Models\GroupChatMessage;
use App\Models\JitsiRoom;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ResetDailyChats extends Command
{
    protected $signature = 'affirmspace:reset-chats {--force : Skip confirmation}';

    protected $description =
        'Delete daily chat history and clean up expired anonymous rooms';

    public function handle(): int
    {
        if (! $this->option('force')) {
            if (! $this->confirm(
                'This permanently deletes chat messages and associated files. Continue?'
            )) {
                $this->warn('Cleanup cancelled.');
                return self::SUCCESS;
            }
        }

        $disk = Storage::disk('public');

        try {
            /*
             * 1. Reset all one-to-one chat messages.
             */
            $oneToOneCount = ChatMessage::count();

            $this->deleteAttachments(
                ChatMessage::query(),
                'friend-chat/'
            );

            ChatMessage::query()->delete();

            $this->info(
                "One-to-one messages deleted: {$oneToOneCount}"
            );

            /*
             * 2. Reset permanent friend-group messages.
             *
             * Groups, members and group images remain untouched.
             */
            $friendGroupCount = FriendChatGroupMessage::count();

            $this->deleteAttachments(
                FriendChatGroupMessage::query()
            );

            FriendChatGroupMessage::query()->delete();

            $this->info(
                "Friend-group messages deleted: {$friendGroupCount}"
            );

            /*
             * 3. Delete expired anonymous rooms only.
             */
            $expiredRooms = JitsiRoom::query()
                ->where('end_time', '<=', now())
                ->get();

            $expiredRoomCount      = 0;
            $anonymousMessageCount = 0;

            foreach ($expiredRooms as $room) {
                $messages = GroupChatMessage::query()
                    ->where('room_id', $room->id);

                $anonymousMessageCount += $messages->count();

                // Delete only files referenced by this room's messages.
                $this->deleteAttachments(
                    GroupChatMessage::query()
                        ->where('room_id', $room->id),
                    'group-chat/'
                );

                DB::transaction(function () use ($room) {
                    GroupChatMessage::where(
                        'room_id',
                        $room->id
                    )->delete();

                    // Remove membership/pivot records.
                    $room->users()->detach();

                    // Delete the expired room itself.
                    $room->delete();
                });

                $expiredRoomCount++;
            }

            $this->info(
                "Expired anonymous rooms deleted: {$expiredRoomCount}"
            );

            $this->info(
                "Anonymous messages deleted: {$anonymousMessageCount}"
            );

            Log::info('AffirmSpace daily chat cleanup completed', [
                'one_to_one_messages'   => $oneToOneCount,
                'friend_group_messages' => $friendGroupCount,
                'expired_rooms'         => $expiredRoomCount,
                'anonymous_messages'    => $anonymousMessageCount,
            ]);

            $this->info('Cleanup completed successfully.');

            return self::SUCCESS;

        } catch (Throwable $e) {
            Log::error('AffirmSpace chat cleanup failed', [
                'error' => $e->getMessage(),
            ]);

            $this->error(
                'Cleanup failed. Check storage/logs/laravel.log'
            );

            return self::FAILURE;
        }
    }

    /**
     * Delete files referenced by message records.
     *
     * The optional prefix restricts deletion to the expected
     * directory for one-to-one and anonymous chat attachments.
     */
    private function deleteAttachments(
        Builder $query,
        ?string $requiredPrefix = null
    ): void {
        $disk = Storage::disk('public');

        $query->select('id', 'attachment_path')
            ->whereNotNull('attachment_path')
            ->orderBy('id')
            ->chunkById(200, function ($messages) use (
                $disk,
                $requiredPrefix
            ) {
                foreach ($messages as $message) {
                    $path = $message->attachment_path;

                    if (! is_string($path) || $path === '') {
                        continue;
                    }

                    // Only allow relative paths within the storage disk.
                    if (
                        str_starts_with($path, '/') ||
                        str_contains($path, '..') ||
                        str_contains($path, '\\')
                    ) {
                        Log::warning(
                            'Skipped unsafe chat attachment path',
                            ['message_id' => $message->id]
                        );

                        continue;
                    }

                    if (
                        $requiredPrefix !== null &&
                        ! str_starts_with($path, $requiredPrefix)
                    ) {
                        Log::warning(
                            'Skipped unexpected chat attachment path',
                            ['message_id' => $message->id]
                        );

                        continue;
                    }

                    $disk->delete($path);
                }
            });
    }
}
