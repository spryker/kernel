<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\Spryker\Client\Kernel;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\SearchClientInterface;
use Spryker\Client\Session\SessionClientInterface;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

/**
 * @group Spryker
 * @group Client
 * @group Kernel
 * @group AbstractDependencyProvider
 */
class AbstractDependencyProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testProvideServiceLayerDependencies()
    {
        $container = new Container();
        $abstractDependencyContainerMock = $this->getAbstractDependencyContainerMock();
        $this->assertInstanceOf(Container::class, $abstractDependencyContainerMock->provideServiceLayerDependencies($container));
    }

    /**
     * @return void
     */
    public function testContainerShouldContainSessionClient()
    {
        $container = new Container();
        $abstractDependencyContainerMock = $this->getAbstractDependencyContainerMock();
        $abstractDependencyContainerMock->provideServiceLayerDependencies($container);
        $this->assertInstanceOf(SessionClientInterface::class, $container[AbstractDependencyProvider::CLIENT_SESSION]);
    }

    /**
     * @return void
     */
    public function testContainerShouldContainZedRequestClient()
    {
        $container = new Container();
        $abstractDependencyContainerMock = $this->getAbstractDependencyContainerMock();
        $abstractDependencyContainerMock->provideServiceLayerDependencies($container);
        $this->assertInstanceOf(ZedRequestClientInterface::class, $container[AbstractDependencyProvider::CLIENT_ZED_REQUEST]);
    }

    /**
     * @return void
     */
    public function testContainerShouldContainKvStorageClient()
    {
        $container = new Container();
        $abstractDependencyContainerMock = $this->getAbstractDependencyContainerMock();
        $abstractDependencyContainerMock->provideServiceLayerDependencies($container);
        $this->assertInstanceOf(StorageClientInterface::class, $container[AbstractDependencyProvider::CLIENT_KV_STORAGE]);
    }

    /**
     * @return void
     */
    public function testContainerShouldContainSearchClient()
    {
        $container = new Container();
        $abstractDependencyContainerMock = $this->getAbstractDependencyContainerMock();
        $abstractDependencyContainerMock->provideServiceLayerDependencies($container);
        $this->assertInstanceOf(SearchClientInterface::class, $container[AbstractDependencyProvider::CLIENT_SEARCH]);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Client\Kernel\AbstractDependencyProvider
     */
    private function getAbstractDependencyContainerMock()
    {
        $abstractDependencyContainerMock = $this->getMockForAbstractClass(AbstractDependencyProvider::class);

        return $abstractDependencyContainerMock;
    }

}
