<?php

namespace DanackTest\SlimAurynInvoker;

use Auryn\Injector;
use Pimple\Container;
use Danack\SlimAurynInvoker\SlimAurynInvoker;
use Danack\SlimAurynInvoker\SlimAurynInvokerFactory;
use DanackTest\BaseTestCase;



class SlimAurynInvokerFactoryTest extends BaseTestCase
{
    public function testCreate()
    {
        $injector = new Injector();
        $container = new Container();
        $invokerFactory = new SlimAurynInvokerFactory($injector);
        $invoker = $invokerFactory($container);
        $this->assertInstanceOf(SlimAurynInvoker::class, $invoker);
    }
}
