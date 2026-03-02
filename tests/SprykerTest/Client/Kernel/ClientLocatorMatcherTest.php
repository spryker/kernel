<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\Kernel;

use Codeception\Test\Unit;
use Spryker\Client\Kernel\ClientLocatorMatcher;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group Kernel
 * @group ClientLocatorMatcherTest
 * Add your own group annotations below this line
 */
class ClientLocatorMatcherTest extends Unit
{
    public function testMatchShouldReturnTrueIfMethodStartsWithClient(): void
    {
        $this->assertTrue((new ClientLocatorMatcher())->match('client'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithClient(): void
    {
        $this->assertFalse((new ClientLocatorMatcher())->match('locatorFoo'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithClientButClientInString(): void
    {
        $this->assertFalse((new ClientLocatorMatcher())->match('locatorClient'));
    }
}
