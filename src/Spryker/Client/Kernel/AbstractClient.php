<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Kernel;

use Spryker\Client\Kernel\ClassResolver\Factory\FactoryResolver;
use Spryker\Shared\ZedRequest\Client\Message;

abstract class AbstractClient
{

    /**
     * @var \Spryker\Client\Kernel\AbstractFactory
     */
    private $factory;

    /**
     * @return \Spryker\Client\Kernel\AbstractFactory
     */
    protected function getFactory()
    {
        if ($this->factory === null) {
            $this->factory = $this->resolveFactory();
        }

        return $this->factory;
    }

    /**
     * @throws \Spryker\Client\Kernel\ClassResolver\Factory\FactoryNotFoundException
     *
     * @return \Spryker\Client\Kernel\AbstractFactory
     */
    private function resolveFactory()
    {
        return $this->getFactoryResolver()->resolve($this);
    }

    /**
     * @return \Spryker\Client\Kernel\ClassResolver\Factory\FactoryResolver
     */
    private function getFactoryResolver()
    {
        return new FactoryResolver();
    }

    /**
     * @return \Spryker\Client\ZedRequest\Stub\BaseStub
     */
    protected function getZedStub()
    {
        $factory = $this->getFactory();
        if (!method_exists($factory, 'createZedStub')) {
            throw new \BadMethodCallException(
                sprintf('createZedStub method is not implemented in "%s".', get_class($factory))
            );
        }

        return $this->getFactory()->createZedStub();
    }

    /**
     * @api
     *
     * @return \Spryker\Shared\ZedRequest\Client\Message[]
     */
    public function getZedInfoMessages()
    {
        return $this->getZedStub()->getInfoMessages();
    }

    /**
     * @api
     *
     * @return \Spryker\Shared\ZedRequest\Client\Message[]
     */
    public function getZedSuccessMessages()
    {
        return $this->getZedStub()->getSuccessMessages();
    }

    /**
     * @api
     *
     * @return \Spryker\Shared\ZedRequest\Client\Message[]
     */
    public function getZedErrorMessages()
    {
        return $this->getZedStub()->getErrorMessages();
    }

}
