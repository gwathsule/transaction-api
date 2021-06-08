<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    protected const STATUS_OK = 200;
    protected const CONTENT_TYPE_RESPONSE = 'application/json';

    /**
     * @param string $message
     * @param string $category
     * @param array $data
     * @return Response
     */
    protected function buildUserErrorResponse(
        string $message,
        string $category,
        int $statusError,
        array $data = []
    ) {
        $content = [
            'error' => true,
            'category' => $category,
            'message' => $message,
            'data' => $data
        ];

        return response($content, $statusError)
            ->header('Content-Type', self::CONTENT_TYPE_RESPONSE);
    }

    /**
     * @param array $content
     * @return Response
     */
    protected function buildSuccessfulResponse(array $content)
    {
        return response($content, self::STATUS_OK)
            ->header('Content-Type', self::CONTENT_TYPE_RESPONSE);
    }
}
