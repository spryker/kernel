<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Kernel\Communication\Fixtures\AbstractPlugin\Plugin;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Kernel\Business\AbstractFacade;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

class FooPlugin extends AbstractPlugin
{
    public function getFactory(): AbstractCommunicationFactory
    {
        return parent::getFactory();
    }

    public function getBusinessFactory(): AbstractBusinessFactory
    {
        return parent::getBusinessFactory();
    }

    public function getFacade(): AbstractFacade
    {
        return parent::getFacade();
    }

    public function getQueryContainer(): AbstractQueryContainer
    {
        return parent::getQueryContainer();
    }

    protected function getBundleName(): string
    {
        return 'Kernel';
    }
}
