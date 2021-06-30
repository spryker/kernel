<?php

namespace Spryker\Glue\Kernel\Backend\Factory;

use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\Kernel\Backend\Container\BackendContainer;

class AbstractBackendFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function createContainer()
    {
        $containerGlobals = $this->createContainerGlobals();

        return new BackendContainer($containerGlobals->getContainerGlobals());
    }
}
