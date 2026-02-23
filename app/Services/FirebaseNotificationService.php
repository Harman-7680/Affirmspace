<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseNotificationService
{
    public function send(
        ?string $deviceToken,
        string $title,
        string $body,
        array $data = []
    ): void {

        // Skip if token null or empty
        if (empty($deviceToken)) {
            Log::warning('FCM skipped: Token is null or empty');
            return;
        }

        try {

            $message = CloudMessage::withTarget('token', $deviceToken)
                ->withNotification(Notification::create($title, $body))
                ->withData($data);

            Log::info('FCM TOKEN DEBUG', [
                'token'  => $deviceToken,
                'length' => strlen($deviceToken),
            ]);

            Firebase::messaging()->send($message);

        } catch (\Throwable $e) {

            // Prevent crash if token invalid
            Log::error('FCM Send Failed', [
                'error' => $e->getMessage(),
                'token' => $deviceToken,
            ]);

            return; // silently skip
        }
    }
}
