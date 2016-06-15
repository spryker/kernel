<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\Kernel\Dependency\Injector;

use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorCollection;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorCollectionInterface;
use Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorInterface;

/**
 * @group Spryker
 * @group Zed
 * @group Kernel
 * @group Dependency
 * @group DependencyInjectorCollection
 */
class DependencyInjectorCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testAddDependencyInjectorShouldReturnInstance()
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $result = $dependencyInjectorCollection->addDependencyInjector($this->getDependencyInjectorMock());

        $this->assertInstanceOf(DependencyInjectorCollectionInterface::class, $result);
    }

    /**
     * @return void
     */
    public function testGetDependencyInjectorShouldReturnInstance()
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $dependencyInjectorMock = $this->getDependencyInjectorMock();
        $dependencyInjectorCollection->addDependencyInjector($dependencyInjectorMock);

        $dependencyInjector = $dependencyInjectorCollection->getDependencyInjector();
        $this->assertSame($dependencyInjectorMock, $dependencyInjector[0]);
    }

    /**
     * @return void
     */
    public function testCountShouldReturnCountOfAddedDependencyInjector()
    {
        $dependencyInjectorCollection = new DependencyInjectorCollection();
        $this->assertSame(0, $dependencyInjectorCollection->count());

        $dependencyInjectorMock = $this->getDependencyInjectorMock();
        $dependencyInjectorCollection->addDependencyInjector($dependencyInjectorMock);

        $this->assertSame(1, $dependencyInjectorCollection->count());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Kernel\Dependency\Injector\DependencyInjectorInterface
     */
    private function getDependencyInjectorMock()
    {
        return $this->getMock(DependencyInjectorInterface::class);
    }

}
