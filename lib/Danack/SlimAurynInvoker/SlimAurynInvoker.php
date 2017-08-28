<?php

namespace Danack\SlimAurynInvoker;

use Auryn\Injector;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SlimAurynInvoker
{
    /** @var   */
    private $injector;

    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function __invoke(
        $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ) {
        Util::setInjectorInfo($this->injector, $request, $response, $routeArguments);

        // Execute the callable
        $builtResponse = $this->injector->execute($callable);

        // If it's a partial response.
        if ($builtResponse instanceof \Danack\Response\Response) {
            return Util::processResponse($builtResponse, $response);
        }

        // TODO - add support for streaming response
        // PRs are welcome.

        // A mutated response object
        if ($builtResponse instanceof ResponseInterface) {
            return $builtResponse;
        }

        $message = 'Dispatched function did not return an object of type ".
            "\Psr\Http\Message\ResponseInterface, or \Danack\Response\Response.';

        throw new SlimAurynInvokerException($message);
    }
}
