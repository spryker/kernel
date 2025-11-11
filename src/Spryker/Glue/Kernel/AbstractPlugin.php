<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel;

use Spryker\Service\Container\ContainerTrait;

abstract class AbstractPlugin implements ModuleNameAwareInterface
{
    use ClientResolverAwareTrait;
    use FactoryResolverAwareTrait;
    use BundleConfigResolverAwareTrait;
    use ContainerTrait;

    /**
     * @api
     *
     * @return string
     */
    public function getModuleName(): string
    {
        $calledClass = $this->getFactoryResolver()->setCallerClass($this);
        $classInfo = $calledClass->getClassInfo();

        return $classInfo->getModule();
    }
}
