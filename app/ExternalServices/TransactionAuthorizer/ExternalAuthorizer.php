<?php

namespace App\ExternalServices\TransactionAuthorizer;

use App\Core\Authorizer;
use App\Support\CurlClient;
use Exception;

class ExternalAuthorizer implements Authorizer
{
    public const URL = "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6";

    private CurlClient $client;

    public function __construct(CurlClient $client)
    {
        $this->client = $client;
    }

    public function isAuthorized(): bool
    {
        try {
            $data = $this->client->performRequest(self::URL, true);
            if ($data['message'] === 'Autorizado') {
                return true;
            }
        } catch (Exception $exception) {
            throw new AuthorizerException($exception->getMessage());
        }
        return false;
    }
}
