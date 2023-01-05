<?php

namespace Spryker\Glue\Kernel\Backend\Controller;

use Spryker\Glue\Kernel\Backend\Factory\AbstractBackendFactory;
use Spryker\Glue\Kernel\Controller\AbstractController;
use Spryker\Glue\Kernel\Exception\Controller\InvalidAbstractFactoryException;

class AbstractBackendController extends AbstractController
{
    /**
     * @return \Spryker\Glue\Kernel\AbstractFactory
     */
    protected function getFactory()
    {
        parent::getFactory();

        if(!$this->factory instanceof AbstractBackendFactory) {
            throw new InvalidAbstractFactoryException();
        }

        return $this->factory;
    }
}
