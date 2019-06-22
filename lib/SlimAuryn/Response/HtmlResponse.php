<?php

namespace SlimAuryn\Response;

use SlimAuryn\Response\StubResponse;

class HtmlResponse implements StubResponse
{
    /** @var int */
    private $status;

    /** @var string */
    private $body;

    private $headers = [];

    public function getStatus() : int
    {
        return $this->status;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * HtmlResponse constructor.
     * @param string $html
     * @param array $headers
     */
    public function __construct(string $html, array $headers = [], int $status = 200)
    {
        $standardHeaders = [
            'Content-Type' => 'text/html'
        ];

        $this->headers = array_merge($standardHeaders, $headers);
        $this->body = $html;
        $this->status = $status;
    }

    public function getBody() : string
    {
        return $this->body;
    }
}
