<?php

namespace Spryker\Glue\Kernel\Backend\Controller;

use Spryker\Glue\Kernel\Backend\Factory\AbstractBackendFactory;
use Spryker\Glue\Kernel\Controller\FormattedAbstractController;

class FormattedAbstractBackendController extends FormattedAbstractController
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
