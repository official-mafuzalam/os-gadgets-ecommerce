<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacebookCapiService
{
    protected $pixelId;
    protected $accessToken;

    public function __construct()
    {
        $this->pixelId = setting('fb_pixel_id');
        $this->accessToken = setting('facebook_access_token');
    }

    public function sendEvent(string $eventName, string $eventId, array $userData = [], array $customData = [])
    {
        if (!$this->pixelId || !$this->accessToken) {
            return false;
        }

        $payload = [
            'data' => [[
                'event_name'     => $eventName,
                'event_time'     => time(),
                'event_id'       => $eventId,
                'action_source'  => 'website',
                'event_source_url' => url()->current(),
                'user_data'      => $userData,
                'custom_data'    => $customData,
            ]],
            'access_token' => $this->accessToken,
        ];

        return Http::post("https://graph.facebook.com/v20.0/{$this->pixelId}/events", $payload)->json();
    }
}
