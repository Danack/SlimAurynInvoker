<?php

namespace Danack\Response;

use Danack\Response\Response;

class HtmlResponse implements Response
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
     * HtmlResponse constructor.
     * @param string $html
     * @param array $headers
     */
    public function __construct(string $html, array $headers = [])
    {
        $standardHeaders = [
            'Content-Type' => 'text/html'
        ];

        // TODO - we could lock down the javascript and other resources that can be run on
        // a site, via a CSP header, like one of the following.

        // Content-Security-Policy: script-src 'unsafe-inline';report-uri /my_amazing_csp_report_parser;
        // Content-Security-Policy-Report-Only: default-src 'self'; ...; report-uri /my_amazing_csp_report_parser;

        $this->headers = array_merge($standardHeaders, $headers);
        $this->body = $html;
    }

    public function getBody()
    {
        return $this->body;
    }
}
