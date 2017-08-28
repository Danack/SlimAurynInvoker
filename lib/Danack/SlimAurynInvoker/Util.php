<?php

namespace Danack\SlimAurynInvoker;

use Auryn\Injector;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Danack\Response\Response;

/**
 * Class Util
 */
class Util
{
    /**
     * Put information about the request/response into the injector
     * @param Injector $injector
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $routeArguments
     */
    public static function setInjectorInfo(
        Injector $injector,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ) {
        $injector->alias(ServerRequestInterface::class, get_class($request));
        $injector->share($request);
        $injector->alias(ResponseInterface::class, get_class($response));
        $injector->share($response);
        foreach ($routeArguments as $key => $value) {
            $injector->defineParam($key, $value);
        }

        $routeParams = new RouteParams($routeArguments);
        $injector->share($routeParams);
    }

    /**
     * @param Response $builtResponse
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function processResponse(Response $builtResponse, ResponseInterface $response)
    {
        $response = $response->withStatus($builtResponse->getStatus());
        foreach ($builtResponse->getHeaders() as $key => $value) {
            /** @var $response \Psr\Http\Message\ResponseInterface */
            $response = $response->withHeader($key, $value);
        }
        $response->getBody()->write($builtResponse->getBody());

        return $response;
    }
}
