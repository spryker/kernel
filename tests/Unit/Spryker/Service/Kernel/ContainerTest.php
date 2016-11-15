<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Service\Kernel;

use Spryker\Service\Kernel\Container;
use Spryker\Shared\Kernel\LocatorLocatorInterface;

/**
 * @group Unit
 * @group Spryker
 * @group Service
 * @group Kernel
 * @group ContainerTest
 */
class ContainerTest extends \PHPUnit_Framework_TestCase
{

    const TEST_VALUE = 'foo';
    const TEST_KEY = 'test.value';

    /**
     * @return void
     */
    public function testGetLocatorShouldReturnInstanceOfLocator()
    {
        $container = new Container();

        $this->assertInstanceOf(LocatorLocatorInterface::class, $container->getLocator());
    }

}
