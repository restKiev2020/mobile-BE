<?php


namespace App\Http\Services;

use App\Models\Advert;
use App\Models\AdvertRequest;
use App\Models\Appointment;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\Common\HttpMethodsClient as HttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use OneSignal\OneSignal;

class NotificationService
{
    const ONESIGNAL_APP_ID = '88063231-88ae-4a9a-95e9-ea8da07e71da';

    const ONESIGNAL_APP_KEY = 'MTM4ZjExMGUtY2VmYy00NDM0LWI1MWEtZmJmYWNlZTJkYTky';
    /**
     * @var HttpClient
     */
    private $api;

    public function __construct()
    {
        $guzzle = new GuzzleClient([]);
        $this->api = new HttpClient(new GuzzleAdapter($guzzle), new GuzzleMessageFactory());
    }

    public function sendMessage(string $title, string $text, $userId, array $data)
    {
        $notificationBody = [
            'app_id' => self::ONESIGNAL_APP_ID,
            'contents' => [
                'en' => $text,
            ],
            'headings' => ['en' => $title],
            'channel_for_external_user_ids' => 'push',
            'ios_badgeType' => 'Increase',
            'ios_badgeCount' => '1',
            'data' => $data,
        ];

        /*if ($notification->getImage()) {
            $notificationBody['big_picture'] = $notification->getImage();
            $notificationBody['ios_attachments'] = [
                'id1' => $notification->getImage()
            ];
        }

        if ($notification->getTemplate()) {
            $notificationBody['template_id'] = $notification->getTemplate();
        }*/
        $notificationBody['include_external_user_ids'] = [$userId];
        /*if ($ids) {
            $notificationBody['filters'] = [];
            foreach ($ids as $i => $id) {
                if ($i) {
                    $notificationBody['filters'][] = [
                        'operator' => 'OR',
                    ];
                }
                $notificationBody['filters'][] = [
                    'field' => 'tag', 'key' => $id, 'relation' => '=', 'value' => $id
                ];
            }
            //
        }*/


        $this->api->send('POST', OneSignal::API_URL . '/notifications', [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . self::ONESIGNAL_APP_KEY,
        ], json_encode($notificationBody));
    }
}
