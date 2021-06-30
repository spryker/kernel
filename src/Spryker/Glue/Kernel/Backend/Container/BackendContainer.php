<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel\Backend\Container;

use Spryker\Glue\Kernel\Backend\Locator\BackendLocator;
use Spryker\Glue\Kernel\Container;

class BackendContainer extends Container
{
    /**
     * @return \Generated\Glue\Ide\AutoCompletion|\Spryker\Shared\Kernel\LocatorLocatorInterface
     */
    public function getLocator()
    {
        return BackendLocator::getInstance();
    }
}
