<?php

namespace Danack\SlimAurynInvoker;

use Auryn\Injector;
use Pimple\Container;
use Danack\SlimAurynInvoker\SlimAurynInvoker;

class SlimAurynInvokerFactory
{
    /**
     * SlimAurynInvokerFactory constructor.
     * @param Injector $injector
     */
    public function __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    /**
     * @param Container $container
     * @return \Danack\SlimAurynInvoker\SlimAurynInvoker
     */
    public function __invoke(Container $container)
    {
        return new SlimAurynInvoker($this->injector);
    }
}
