<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel\Backend;

use Spryker\Glue\Kernel\Container as GlueContainer;

class Container extends GlueContainer
{
    /**
     * @return \Generated\Glue\Ide\AutoCompletion|\Generated\Zed\Ide\AutoCompletion|\Spryker\Shared\Kernel\LocatorLocatorInterface
     */
    public function getLocator()
    {
        //@todo we might need to split up Zed IDE completion from Facade IDE completion to support completing only for facades
        return Locator::getInstance();
    }
}
