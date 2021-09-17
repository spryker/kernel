<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel\Backend\Controller;

use Spryker\Glue\Kernel\Backend\Exception\InvalidAbstractFactoryException;
use Spryker\Glue\Kernel\Backend\Factory\AbstractFactory;
use Spryker\Glue\Kernel\Controller\AbstractController as GlueAbstractController;

abstract class AbstractController extends GlueAbstractController
{
    /**
     * @return \Spryker\Glue\Kernel\AbstractFactory
     */
    protected function getFactory()
    {
        parent::getFactory();

        if(!$this->factory instanceof AbstractFactory) {
            throw new InvalidAbstractFactoryException();
        }

        return $this->factory;
    }
}
