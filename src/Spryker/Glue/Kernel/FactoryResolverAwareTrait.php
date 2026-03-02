<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel;

use Spryker\Glue\Kernel\ClassResolver\Factory\FactoryResolver;

trait FactoryResolverAwareTrait
{
    /**
     * @var \Spryker\Glue\Kernel\AbstractFactory|null
     */
    protected $factory;

    /**
     * @param \Spryker\Glue\Kernel\AbstractFactory $factory
     *
     * @return $this
     */
    public function setFactory(AbstractFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    protected function getFactory(): AbstractFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    protected function resolveFactory(): AbstractFactory
    {
        return $this->getFactoryResolver()->resolve($this);
    }

    protected function getFactoryResolver(): FactoryResolver
    {
        return new FactoryResolver();
    }
}
