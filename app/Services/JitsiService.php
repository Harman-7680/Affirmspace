<?php
namespace App\Services;

use Carbon\Carbon;
use Firebase\JWT\JWT;

class JitsiService
{
    public static function generateToken(string $room, $user): string
    {
        $appId      = config('services.jitsi.app_id');
        $keyId      = config('services.jitsi.key_id');
        $privateKey = config('services.jitsi.private_key');

        // JWT HEADER (kid REQUIRED)
        $headers = [
            'alg' => 'RS256',
            'kid' => $keyId,
            'typ' => 'JWT',
        ];

        // JWT PAYLOAD
        $payload = [
            'iss'     => 'chat',
            'aud'     => 'jitsi',
            'sub'     => $appId,
            'room'    => '*',
            'exp'     => Carbon::now()->addHour()->timestamp,
            'nbf'     => Carbon::now()->subMinutes(5)->timestamp,

            'context' => [
                'user'     => [
                    'id'        => (string) $user->id,
                    'name'      => $user->first_name,
                    'email'     => $user->email,
                    'moderator' => true,
                ],
                'features' => [
                    'livestreaming' => false,
                    'recording'     => false,
                    'transcription' => false,
                    'outbound-call' => false,
                    'inbound-call'  => false,
                    'file-upload'   => true,
                    'chat'          => true,
                ],
            ],
        ];

        return JWT::encode($payload, $privateKey, 'RS256', null, $headers);
    }
}
