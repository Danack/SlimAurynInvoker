<?php

namespace DanackTest\SlimAurynInvoker;

use Auryn\Injector;
use Danack\SlimAurynInvoker\SlimAurynInvoker;
use Danack\Response\TextResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use DanackTest\BaseTestCase;
use Zend\Diactoros\Response;
use Danack\SlimAurynInvoker\SlimAurynInvokerException;

class SlimAurynInvokerTest extends BaseTestCase
{
    /**
     * Test when a callable returns a stub response, all is well.
     */
    public function testStubResponse()
    {
        $injector = new Injector();
        $invoker = new SlimAurynInvoker($injector);

        $requestReceived = null;
        $callable = function (ServerRequestInterface $request) use (&$requestReceived) {
            // This response will have a 200 status
            $requestReceived = $request;
            return new TextResponse("This is a response", [], 420);
        };

        /** @var $requestMock \Psr\Http\Message\ServerRequestInterface */
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $response = new Response();
        $returnedResponse = $invoker(
            $callable,
            $requestMock,
            $response,
            []
        );

        // Check that the request object reached the callable.
        self::assertSame($requestMock, $requestReceived);

        // Check that the response will passed into the PSR7 response correctly
        self::assertEquals(420, $returnedResponse->getStatusCode());
        self::assertEquals(true, $returnedResponse->hasHeader('Content-Type'));
        self::assertEquals(
            ['text/plain'],
            $returnedResponse->getHeader('Content-Type')
        );
    }

    /**
     * Test that when a callable returns a PSR 7 response, all is well.
     */
    public function testPsr7Response()
    {
        $injector = new Injector();
        $invoker = new SlimAurynInvoker($injector);

        $requestReceived = null;
        $callable = function (ResponseInterface $response) {

            $response = $response->withStatus(420);
            /** @var $response \Psr\Http\Message\ResponseInterface */
            $response = $response->withHeader('Content-Type', 'text/awesome');

            return $response;
        };

        /** @var $requestMock \Psr\Http\Message\ServerRequestInterface */
        $requestMock = $this->createMock(ServerRequestInterface::class);

        $response = new Response();
        $returnedResponse = $invoker(
            $callable,
            $requestMock,
            $response,
            []
        );

        self::assertEquals(420, $returnedResponse->getStatusCode());
        self::assertEquals(true, $returnedResponse->hasHeader('Content-Type'));
        self::assertEquals(
            ['text/awesome'],
            $returnedResponse->getHeader('Content-Type')
        );
    }

    /**
     * Test that a callable that does not return an expected type
     * throws an exception.
     */
    public function testBadCallable()
    {
        $injector = new Injector();
        $invoker = new SlimAurynInvoker($injector);

        $callable = function () {};
        $this->expectException(SlimAurynInvokerException::class);

        /** @var $requestMock \Psr\Http\Message\ServerRequestInterface */
        $requestMock = $this->createMock(ServerRequestInterface::class);
        $response = new Response();

        $invoker(
            $callable,
            $requestMock,
            $response,
            []
        );
    }
}
