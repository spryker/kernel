<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Service\Kernel\Fixtures;

use Spryker\Service\Kernel\AbstractBundleDependencyProvider;
use Spryker\Service\Kernel\AbstractServiceFactory;
use Spryker\Service\Kernel\Container;
use SprykerTest\Service\Kernel\AbstractServiceFactoryTest;

class ServiceFactory extends AbstractServiceFactory
{
    protected function provideExternalDependencies(
        AbstractBundleDependencyProvider $dependencyProvider,
        Container $container
    ): void {
        $container[AbstractServiceFactoryTest::CONTAINER_KEY] = AbstractServiceFactoryTest::CONTAINER_VALUE;
    }
}
