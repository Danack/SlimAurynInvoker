<?php

declare(strict_types=1);

use Auryn\Injector;

function createSlimAurynInvokerFactory(
    Injector $injector,
    \SlimAuryn\RouteMiddlewares $routeMiddlewares
): SlimAuryn\SlimAurynInvokerFactory {
    $resultMappers = getResultMappers();

    return new SlimAuryn\SlimAurynInvokerFactory(
        $injector,
        $routeMiddlewares,
        $resultMappers
    );
}

function createExceptionMiddleware(): SlimAuryn\ExceptionMiddleware
{
    return new SlimAuryn\ExceptionMiddleware(
        getExceptionMappers(),
        getResultMappers()
    );
}

function createFoo(): \SlimAurynTest\Foo\Foo
{
    return new \SlimAurynTest\Foo\StandardFoo(true);
}
