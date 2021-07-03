<?php

namespace SlimAuryn\ResponseMapper;

use Psr\Http\Message\ResponseInterface;
use SlimAuryn\Response\StubResponse;

/**
 *
 * When PHP has function autoloading, this will be replaced with a set of functions.
 */
class ResponseMapper
{
    /**
     * Extract the status, headers and body from a StubResponse and
     * set the values on the PSR7 response
     * @param StubResponse $builtResponse
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function mapStubResponseToPsr7(
        StubResponse $builtResponse,
        ResponseInterface $response
    ) {
        $status = $builtResponse->getStatus();
        $reasonPhrase = static::getReasonPhrase($status);

        $response = $response->withStatus($builtResponse->getStatus(), $reasonPhrase);
        foreach ($builtResponse->getHeaders() as $key => $value) {
            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = $response->withHeader($key, $value);
        }
        $response->getBody()->write($builtResponse->getBody());

        return $response;
    }

    public static function getReasonPhrase(int $status): string
    {
        $customPhrases = [
            420 => 'Enhance your calm',
            512 => 'Server known limitation',
        ];

        if (array_key_exists($status, $customPhrases) === true) {
            return $customPhrases[$status];
        }


        return '';
    }

    /**
     * Just directly return the PSR7 Response without processing
     * @param ResponseInterface $controllerResult
     * @param ResponseInterface $originalResponse
     * @return ResponseInterface
     */
    public static function passThroughResponse(
        ResponseInterface $controllerResult,
        ResponseInterface $originalResponse
    ) {
        return $controllerResult;
    }
}
