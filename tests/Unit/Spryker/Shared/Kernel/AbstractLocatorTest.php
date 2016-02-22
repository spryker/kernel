<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Shared\Kernel;

use Unit\Spryker\Shared\Kernel\Fixtures\MissingPropertyLocator;

/**
 * @group Kernel
 * @group Locator
 * @group AbstractLocator
 */
class AbstractLocatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testCreateInstanceShouldThrowExceptionIfApplicationNotDefined()
    {
        $this->setExpectedException('\Exception');

        new MissingPropertyLocator();
    }

    /**
     * @return void
     */
    public function testCanCreateShouldThrowException()
    {
        $this->setExpectedException('\Exception');

        new MissingPropertyLocator();
    }

}
