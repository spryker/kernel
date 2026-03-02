<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\Kernel\Backend;

use Codeception\Test\Unit;
use Spryker\Glue\Kernel\Backend\ResourceLocatorMatcher;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group Kernel
 * @group Backend
 * @group ResourceLocatorMatcherTest
 * Add your own group annotations below this line
 */
class ResourceLocatorMatcherTest extends Unit
{
    public function testMatchingShouldReturnTrueIfMethodStartsWithResource(): void
    {
        $locatorMatcher = new ResourceLocatorMatcher();

        $this->assertTrue($locatorMatcher->match('resourceAdd'));
    }

    public function testMatchingShouldReturnFalseIfMethodDoesNotStartWithResource(): void
    {
        $locatorMatcher = new ResourceLocatorMatcher();

        $this->assertFalse($locatorMatcher->match('locatorFoo'));
    }

    public function testMatchingShouldReturnFalseIfMethodDoesNotStartWithResourceButResourceInString(): void
    {
        $locatorMatcher = new ResourceLocatorMatcher();

        $this->assertFalse($locatorMatcher->match('addResource'));
    }
}
