<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Kernel;

use Spryker\Service\Container\ContainerTrait;

abstract class AbstractPlugin
{
    use ClientResolverAwareTrait;
    use FactoryResolverAwareTrait;
    use ContainerTrait;
}
