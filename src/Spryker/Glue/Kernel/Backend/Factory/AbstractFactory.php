<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel\Backend\Factory;

use Spryker\Glue\Kernel\AbstractFactory as GlueAbstractFactory;
use Spryker\Glue\Kernel\Backend\Container;

/**
 * @method \Spryker\Glue\Kernel\Backend\Container getContainer()
 * @method setContainer(\Spryker\Glue\Kernel\Backend\Container $container)
 */
class AbstractFactory extends GlueAbstractFactory
{
    /**
     * @return \Spryker\Glue\Kernel\Backend\Container
     */
    protected function createContainer()
    {
        $containerGlobals = $this->createContainerGlobals();

        return new Container($containerGlobals->getContainerGlobals());
    }
}
