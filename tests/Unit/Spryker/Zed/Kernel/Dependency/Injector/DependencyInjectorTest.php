<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\Kernel\Dependency\Injector;

use PHPUnit_Framework_TestCase;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjector;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorCollection;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorInterface;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Kernel
 * @group Dependency
 * @group Injector
 * @group DependencyInjectorTest
 */
class DependencyInjectorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testInstantiation()
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $this->assertInstanceOf(DependencyInjectorInterface::class, $dependencyInjector);
    }

    /**
     * @return void
     */
    public function testInjectBusinessLayerDependenciesShouldCallMethodOfRegisteredDependencyInjector()
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $abstractDependencyInjectorMock = $this->getAbstractDependencyInjectorMock();
        $abstractDependencyInjectorMock->expects($this->once())->method('injectBusinessLayerDependencies');

        $dependencyInjectorCollection->addDependencyInjector($abstractDependencyInjectorMock);
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $dependencyInjector->injectBusinessLayerDependencies(new Container());
    }

    /**
     * @return void
     */
    public function testInjectCommunicationLayerDependenciesShouldCallMethodOfRegisteredDependencyInjector()
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $abstractDependencyInjectorMock = $this->getAbstractDependencyInjectorMock();
        $abstractDependencyInjectorMock->expects($this->once())->method('injectCommunicationLayerDependencies');

        $dependencyInjectorCollection->addDependencyInjector($abstractDependencyInjectorMock);
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $dependencyInjector->injectCommunicationLayerDependencies(new Container());
    }

    /**
     * @return void
     */
    public function testInjectPersistenceLayerDependenciesShouldCallMethodOfRegisteredDependencyInjector()
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $abstractDependencyInjectorMock = $this->getAbstractDependencyInjectorMock();
        $abstractDependencyInjectorMock->expects($this->once())->method('injectPersistenceLayerDependencies');

        $dependencyInjectorCollection->addDependencyInjector($abstractDependencyInjectorMock);
        $dependencyInjector = new DependencyInjector($dependencyInjectorCollection);

        $dependencyInjector->injectPersistenceLayerDependencies(new Container());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Kernel\Dependency\Injector\AbstractDependencyInjector
     */
    private function getAbstractDependencyInjectorMock()
    {
        return $this->getMockBuilder(AbstractDependencyInjector::class)->getMock();
    }

}
