<?php

namespace SlimAuryn\Response;

class EmptyResponse implements StubResponse
{
    private $headers;

    /** @var int  */
    private $status;

    const DEFAULT_STATUS = 204;

    public function __construct(array $headers = [], int $status = self::DEFAULT_STATUS)
    {
        $standardHeaders = [];

        $this->headers = array_merge($standardHeaders, $headers);
        $this->status = $status;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function getBody() : string
    {
        return "";
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }
}
