<?php

namespace Danack\SlimAurynInvoker;

use Auryn\Injector;
use Danack\Response\StubResponse;
use Danack\Response\StubResponseMapper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SlimAurynInvoker
{
    /** @var Injector The injector to use for execution */
    private $injector;

    /** @var array A list of callables that can map known return types
     * into PSR-7 Response type.
     */
    private $resultMappers;

    /**
     * SlimAurynInvoker constructor.
     * @param Injector $injector
     * @param array|null $resultMappers
     */
    public function __construct(Injector $injector, array $resultMappers = null)
    {
        $this->injector = $injector;
        if ($resultMappers !== null) {
            $this->resultMappers = $resultMappers;
        }
        // Default to using a single StubResponse mapper.
        else {
            $this->resultMappers = [
                StubResponse::class => [StubResponseMapper::class, 'mapToPsr7Response']
            ];
        }
    }

    /**
     * @param $callable
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $routeArguments
     * @return mixed
     * @throws SlimAurynInvokerException
     */
    public function __invoke(
        $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ) {
        Util::setInjectorInfo($this->injector, $request, $response, $routeArguments);

        // Execute the callable
        $result = $this->injector->execute($callable);

        // Test each of the result mapper, and use an appropriate one.
        foreach ($this->resultMappers as $type => $mapCallable) {
            if ((is_object($result) && $result instanceof $type) ||
              gettype($result) === $type) {
                return $mapCallable($result, $response);
            }
        }

        // if the result is a mutated PSR response object, just return that.
        if ($result instanceof ResponseInterface) {
            return $result;
        }

        // Unknown result type, throw an exception
        $type = gettype($result);
        if ($type === "object") {
            $type = "object of type ". get_class($result);
        }
        $message = sprintf(
            'Dispatched function returned [%s] which is not a".
            "\Psr\Http\Message\ResponseInterface, or any type known to the resultMappers.',
            $type
        );
        throw new SlimAurynInvokerException($message);
    }
}
