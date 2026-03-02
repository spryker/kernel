<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Service\Kernel;

use Codeception\Test\Unit;
use Spryker\Service\Kernel\ServiceLocatorMatcher;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Service
 * @group Kernel
 * @group ServiceLocatorMatcherTest
 * Add your own group annotations below this line
 */
class ServiceLocatorMatcherTest extends Unit
{
    public function testMatchShouldReturnTrueIfMethodStartsWithService(): void
    {
        $this->assertTrue((new ServiceLocatorMatcher())->match('service'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithService(): void
    {
        $this->assertFalse((new ServiceLocatorMatcher())->match('locatorFoo'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithServiceButServiceInString(): void
    {
        $this->assertFalse((new ServiceLocatorMatcher())->match('locatorService'));
    }
}
