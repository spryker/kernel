<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Yves\Kernel;

use Spryker\Shared\Kernel\ClassResolver\ModuleNameResolver;

class ModuleNameResolverPrototype extends ModuleNameResolver
{
    protected string $storeName = '';

    public function __construct(string $storeName = '')
    {
        // avoid calling parent constructor
        $this->storeName = $storeName;
    }

    public function getStoreName(): string
    {
        return $this->storeName;
    }
}
