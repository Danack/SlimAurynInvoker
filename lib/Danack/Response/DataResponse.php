<?php

namespace Danack\Response;

use Danack\Response\Response;

class DataResponse implements Response
{
    private $body;

    private $headers = [];

    private $statusCode;

    public function getStatus()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * JsonResponse constructor.
     * @param $data
     * @param array $headers
     */
    public function __construct($data, array $headers = [], int $statusCode = 200)
    {
        $this->data = $data;

        $standardHeaders = [
            'Content-Type' => 'application/json'
        ];

        $this->headers = array_merge($standardHeaders, $headers);
        $this->body = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $this->statusCode = $statusCode;
    }

    public function getBody()
    {
        return $this->body;
    }
}
