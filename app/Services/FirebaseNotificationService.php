<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseNotificationService
{
    public function send(
        string $deviceToken,
        string $title,
        string $body,
        array $data = []
    ): void {
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        Log::info('FCM TOKEN DEBUG', [
            'token'  => $deviceToken,
            'length' => strlen($deviceToken),
        ]);

        Firebase::messaging()->send($message);
    }
}
