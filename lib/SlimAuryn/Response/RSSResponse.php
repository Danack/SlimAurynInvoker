<?php

namespace SlimAuryn\Response;

class RSSResponse implements StubResponse
{
    /** @var string  */
    private $body;

    private $headers = [];

    /** @var int  */
    private $status;

    public function getStatus() : int
    {
        return $this->status;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * XMLResponse constructor.
     * @param string $xml
     * @param array $headers
     */
    public function __construct(string $xml, array $headers = [], int $status = 200)
    {
        $standardHeaders = [
            'Content-Type' => 'application/rss+xml; charset=utf-8'
        ];

        $this->headers = array_merge($standardHeaders, $headers);
        $this->body = $xml;
        $this->status = $status;
    }

    public function getBody() : string
    {
        return $this->body;
    }
}
