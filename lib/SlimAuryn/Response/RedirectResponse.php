<?php

namespace SlimAuryn\Response;

use SlimAuryn\Response\StubResponse;

class RedirectResponse implements StubResponse
{
    private $headers = [];

    /** @var int */
    private $status;

    /** @var string */
    private $redirectUri;

    /**
     * RedirectResponse constructor.
     * @param string $uri
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $uri, int $status = 302, array $headers = [])
    {
        $this->redirectUri = $uri;
        $standardHeaders = [
            'Location' => $uri
        ];

        $this->headers = array_merge($standardHeaders, $headers);
        $this->status = $status;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }

    public function getBody() : string
    {
        return "";
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }
}
