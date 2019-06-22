<?php

namespace SlimAurynTest\Response;

use SlimAuryn\Response\EmptyResponse;
use SlimAurynTest\BaseTestCase;

class EmptyResponseTest extends BaseTestCase
{
    public function testWorksCorrectlyWithDefaults()
    {
        $response = new EmptyResponse();
        self::assertEquals('',$response->getBody());
        self::assertEquals(204, $response->getStatus());
    }

    public function testWorksCorrectlyWithSettings()
    {
        $headers = ['x-foo' => 'x-bar'];

        $response = new EmptyResponse($headers, 203);
        self::assertEquals('',$response->getBody());

        self::assertEquals(203, $response->getStatus());
        $setHeaders = $response->getHeaders();
        self::assertCount(1, $setHeaders);

        self::assertArrayHasKey('x-foo', $setHeaders);
        self::assertEquals('x-bar', $setHeaders['x-foo']);
    }
}
