<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Service\Kernel;

use Codeception\Test\Unit;
use Spryker\Service\Kernel\AbstractBundleDependencyProvider;
use Spryker\Service\Kernel\Container;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Service
 * @group Kernel
 * @group AbstractDependencyProviderTest
 * Add your own group annotations below this line
 */
class AbstractDependencyProviderTest extends Unit
{
    public function testCallProvideServiceLayerDependenciesMustReturnContainer(): void
    {
        $container = new Container();

        $abstractDependencyProviderMock = $this->getAbstractDependencyProviderMock();
        $expected = $abstractDependencyProviderMock->provideServiceDependencies($container);

        $this->assertSame($expected, $container);
    }

    private function getAbstractDependencyProviderMock(): AbstractBundleDependencyProvider
    {
        return new class extends AbstractBundleDependencyProvider {
        };
    }
}
