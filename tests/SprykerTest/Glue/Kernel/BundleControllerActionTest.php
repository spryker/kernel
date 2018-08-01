<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\Kernel;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\BundleControllerAction;
use Spryker\Shared\Kernel\ClassResolver\BundleNameResolver;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Glue
 * @group Kernel
 * @group BundleControllerActionTest
 * Add your own group annotations below this line
 */
class BundleControllerActionTest extends Unit
{
    /**
     * @return void
     */
    public function testGetBundleShouldReturnBundleName()
    {
        $bundleControllerAction = new BundleControllerAction('foo', 'bar', 'baz');

        $this->assertSame('foo', $bundleControllerAction->getBundle());
    }

    /**
     * @return void
     */
    public function testGetBundleShouldStripStoreName()
    {
        $bundleControllerAction = $this->getBundleControllerAction('fooDE', 'bar', 'baz', 'DE');

        $this->assertSame('foo', $bundleControllerAction->getBundle());
    }

    /**
     * @param string $bundle
     * @param string $controller
     * @param string $action
     * @param string $storeName
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Glue\Kernel\BundleControllerAction
     */
    protected function getBundleControllerAction($bundle, $controller, $action, $storeName)
    {
        $mock = $this
            ->getMockBuilder(BundleControllerAction::class)
            ->setMethods(['getBundleNameResolver'])
            ->setConstructorArgs([$bundle, $controller, $action])
            ->getMock();

        $mock
            ->method('getBundleNameResolver')
            ->will($this->returnValue($this->getBundleNameResolverMock($storeName)));

        return $mock;
    }

    /**
     * @param string $storeName
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Shared\Kernel\ClassResolver\BundleNameResolver
     */
    protected function getBundleNameResolverMock($storeName)
    {
        $mock = $this
            ->getMockBuilder(BundleNameResolver::class)
            ->setMethods(['getStoreName'])
            ->getMock();

        $mock
            ->method('getStoreName')
            ->will($this->returnValue($storeName));

        return $mock;
    }

    /**
     * @return void
     */
    public function testGetControllerShouldReturnControllerName()
    {
        $bundleControllerAction = new BundleControllerAction('foo', 'bar', 'baz');

        $this->assertSame('bar', $bundleControllerAction->getController());
    }

    /**
     * @return void
     */
    public function testGetActionShouldReturnActionName()
    {
        $bundleControllerAction = new BundleControllerAction('foo', 'bar', 'baz');

        $this->assertSame('baz', $bundleControllerAction->getAction());
    }
}
