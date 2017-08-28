<?php

namespace Danack\Response;

use Danack\Response\Response;

class DataNoCacheResponse implements Response
{
    private $body;

    private $headers = [];

    public function getStatus()
    {
        return 200;
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
    public function __construct($data, array $headers = [])
    {
        $this->data = $data;

        $standardHeaders = [
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache, no-store',
        ];

        $this->headers = array_merge($standardHeaders, $headers);
        $this->body = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function getBody()
    {
        return $this->body;
    }
}
