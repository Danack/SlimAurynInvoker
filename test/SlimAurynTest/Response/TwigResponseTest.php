<?php

namespace SlimAurynTest\Response;

use SlimAuryn\Response\TwigResponse;
use SlimAurynTest\BaseTestCase;

class TwigResponseTest extends BaseTestCase
{
    public function testWorksCorrectlyWithDefaults()
    {
        $templateName = 'john.html.tpl';
        $parameters = [
            'foo' => 'bar'
        ];
        $status = 203;

        $headers = [
            'x-foo' => 'bar'
        ];

        $response = new TwigResponse(
            $templateName,
            $parameters,
            $status,
            $headers
        );

        $this->assertSame($templateName,$response->getTemplateName());
        $this->assertSame($parameters, $response->getParameters());
        $this->assertSame($status, $response->getStatus());

        $this->assertSame($headers, $response->getHeaders());
    }
}
