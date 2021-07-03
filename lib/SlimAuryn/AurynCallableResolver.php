<?php

declare(strict_types = 1);

namespace SlimAuryn;

use Interop\Container\ContainerInterface;
use RuntimeException;
use Slim\CallableResolver;
use Slim\Interfaces\CallableResolverInterface;

class AurynCallableResolver implements CallableResolverInterface
{
    private CallableResolver $callableResolver;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        CallableResolver $callableResolver,
        ContainerInterface $container
    ) {
        $this->callableResolver = $callableResolver;
        $this->container = $container;
    }


    /**
     * Resolve toResolve into a closure that that the router can dispatch.
     *
     * If toResolve is of the format 'class:method', then try to extract 'class'
     * from the container otherwise instantiate it and then dispatch 'method'.
     *
     * @param mixed $toResolve
     *
     * @return callable
     *
     * @throws RuntimeException if the callable does not exist
     * @throws RuntimeException if the callable is not resolvable
     */
    public function resolve($toResolve)
    {
        $resolved = $toResolve;

        if (!is_callable($toResolve) && is_string($toResolve)) {
            // check for slim callable as "class:method"
            $callablePattern = '!^([^\:]+)\:{1,2}([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)$!';
            if (preg_match($callablePattern, $toResolve, $matches)) {
                $class = $matches[1];
                $method = $matches[2];

                if ($this->container->has($class)) {
                    $resolved = [$this->container->get($class), $method];
                }
                else {
                    if (!class_exists($class)) {
                        throw new RuntimeException(sprintf('Callable %s does not exist', $class));
                    }
                    $resolved = [new $class($this->container), $method];
                }
            }
            else {
                // check if string is something in the DIC that's callable or is a class name which
                // has an __invoke() method
                $class = $toResolve;
                if ($this->container->has($class)) {
                    $resolved = $this->container->get($class);
                }
                else {
                    if (!class_exists($class)) {
                        throw new RuntimeException(sprintf('Callable %s does not exist', $class));
                    }
                    $resolved = new $class($this->container);
                }
            }
        }

        if (!is_callable($resolved)) {
            throw new RuntimeException(sprintf(
                '%s is not resolvable',
                is_array($toResolve) || is_object($toResolve) ? json_encode($toResolve) : $toResolve
            ));
        }

        return $resolved;
    }
}
