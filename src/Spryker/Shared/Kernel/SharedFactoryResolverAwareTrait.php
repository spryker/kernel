<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel;

use Spryker\Shared\Kernel\ClassResolver\Factory\SharedFactoryResolver;

trait SharedFactoryResolverAwareTrait
{
    /**
     * @var \Spryker\Shared\Kernel\AbstractSharedFactory
     */
    protected $sharedFactory;

    /**
     * @param \Spryker\Shared\Kernel\AbstractSharedFactory $sharedFactory
     *
     * @return $this
     */
    public function setSharedFactory(AbstractSharedFactory $sharedFactory)
    {
        $this->sharedFactory = $sharedFactory;

        return $this;
    }

    protected function getSharedFactory(): AbstractSharedFactory
    {
        if ($this->sharedFactory === null) {
            $this->sharedFactory = $this->resolveSharedFactory();
        }

        return $this->sharedFactory;
    }

    private function resolveSharedFactory(): AbstractSharedFactory
    {
        $resolver = new SharedFactoryResolver();

        return $resolver->resolve($this);
    }
}
