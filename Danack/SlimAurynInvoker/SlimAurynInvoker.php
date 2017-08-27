<?php

namespace Danack\SlimAurynInvoker;

use Auryn\Injector;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


use Slim\Interfaces\InvocationStrategyInterface;
use Dijon\RouteParams;

class SlimAurynInvoker implements InvocationStrategyInterface
{
    /** @var   */
    private $injector;

    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    )
    {

        var_dump($routeArguments);
        exit(0);


        $this->injector->alias(ServerRequestInterface::class, get_class($request));
        $this->injector->share($request);

        $this->injector->alias(ResponseInterface::class, get_class($response));
        $this->injector->share($response);

        foreach ($routeArguments as $key => $value) {
            $this->injector->defineParam($key, $value);
        }


        $routeParams = new RouteParams($args);
        $this->injector->share($routeParams);

        $builtResponse = $injector->execute($callableName);

        if ($builtResponse instanceof \Dijon\Response) {
            $response = $response->withStatus($builtResponse->getStatus());
            foreach ($builtResponse->getHeaders() as $key => $value) {
                $response = $response->withHeader($key, $value);
            }
            $response->getBody()->write($builtResponse->getBody());
            return $response;
        }

        // Presumably a mutated PsrResponse
        return $builtResponse;

    }


}


