<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Kernel\Dependency\Injector;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjector;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorCollection;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Kernel
 * @group Dependency
 * @group Injector
 * @group DependencyInjectorTest
 * Add your own group annotations below this line
 */
class DependencyInjectorTest extends Unit
{
    public function testInstantiation(): void
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $this->assertInstanceOf(DependencyInjectorInterface::class, $dependencyInjector);
    }

    public function testInjectBusinessLayerDependenciesShouldCallMethodOfRegisteredDependencyInjector(): void
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $abstractDependencyInjectorMock = $this->getAbstractDependencyInjectorMock();
        $abstractDependencyInjectorMock->expects($this->once())->method('injectBusinessLayerDependencies');

        $dependencyInjectorCollection->addDependencyInjector($abstractDependencyInjectorMock);
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $dependencyInjector->injectBusinessLayerDependencies(new Container());
    }

    public function testInjectCommunicationLayerDependenciesShouldCallMethodOfRegisteredDependencyInjector(): void
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $abstractDependencyInjectorMock = $this->getAbstractDependencyInjectorMock();
        $abstractDependencyInjectorMock->expects($this->once())->method('injectCommunicationLayerDependencies');

        $dependencyInjectorCollection->addDependencyInjector($abstractDependencyInjectorMock);
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $dependencyInjector->injectCommunicationLayerDependencies(new Container());
    }

    public function testInjectPersistenceLayerDependenciesShouldCallMethodOfRegisteredDependencyInjector(): void
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $abstractDependencyInjectorMock = $this->getAbstractDependencyInjectorMock();
        $abstractDependencyInjectorMock->expects($this->once())->method('injectPersistenceLayerDependencies');

        $dependencyInjectorCollection->addDependencyInjector($abstractDependencyInjectorMock);
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $dependencyInjector->injectPersistenceLayerDependencies(new Container());
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector
     */
    private function getAbstractDependencyInjectorMock(): AbstractDependencyInjector
    {
        return $this->getMockBuilder(AbstractDependencyInjector::class)->getMock();
    }
}
