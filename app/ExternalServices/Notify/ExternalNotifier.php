<?php

namespace App\ExternalServices\Notify;

use App\Core\Notifier;
use App\Support\CurlClient;
use Exception;

class ExternalNotifier implements Notifier
{
    public const URL = "http://o4d9z.mocklab.io/notify";
    private CurlClient $client;

    public function __construct(CurlClient $client)
    {
        $this->client = $client;
    }


    public function notifier($email) : bool
    {
        try {
            $data = $this->client->performRequest(self::URL, true);
            if ($data['message'] === 'Success') {
                return true;
            }
        } catch (Exception $exception) {
            throw new NotifierException($exception->getMessage());
        }
        return false;
    }
}
