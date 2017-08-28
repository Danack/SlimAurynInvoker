<?php

namespace Danack\Response;

use Danack\Response\Response;

class RedirectResponse implements Response
{
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
    public function __construct(string $uri, int $statusCode = 200, array $headers = [])
    {
        $standardHeaders = [
            'location' => $uri
        ];

        $this->headers = array_merge($standardHeaders, $headers);

        $this->statusCode = $statusCode;
    }

    public function getBody()
    {
        return "";
    }
}
