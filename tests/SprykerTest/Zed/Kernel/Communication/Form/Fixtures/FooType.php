<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Kernel\Communication\Form\Fixtures;

use Spryker\Zed\Kernel\Business\AbstractFacade;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Spryker\Zed\Kernel\KernelConfig getConfig()
 * @method \Spryker\Zed\Kernel\Communication\KernelCommunicationFactory getFactory()
 * @method \Spryker\Zed\Kernel\Business\KernelFacadeInterface getFacade()
 */
class FooType extends AbstractType
{
    public function getFactory(): AbstractCommunicationFactory
    {
        return parent::getFactory();
    }

    public function getFacade(): AbstractFacade
    {
        return parent::getFacade();
    }

    public function getQueryContainer(): AbstractQueryContainer
    {
        return parent::getQueryContainer();
    }
}
