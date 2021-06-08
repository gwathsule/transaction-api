<?php

namespace App\ExternalServices\Notify;

use App\Support\CurlClient;
use Exception;

class Notifier
{
    public const URL = "http://o4d9z.mocklab.io/notify";
    private CurlClient $client;

    public function __construct(CurlClient $client)
    {
        $this->client = $client;
    }


    public function notifyUser($email)
    {
        try {
            $data = $this->client->performRequest(self::URL, true);
            if($data['message'] === 'Success') {
                return true;
            }
        } catch (Exception $exception) {
            throw new NotifierException($exception->getMessage());
        }
        return false;
    }
}
