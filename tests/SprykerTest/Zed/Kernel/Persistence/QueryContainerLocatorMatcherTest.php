<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Kernel\Persistence;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Persistence\QueryContainerLocatorMatcher;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Kernel
 * @group Persistence
 * @group QueryContainerLocatorMatcherTest
 * Add your own group annotations below this line
 */
class QueryContainerLocatorMatcherTest extends Unit
{
    public function testMatchShouldReturnTrueIfMethodStartsWithQueryContainer(): void
    {
        $this->assertTrue((new QueryContainerLocatorMatcher())->match('queryContainer'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithQueryContainer(): void
    {
        $this->assertFalse((new QueryContainerLocatorMatcher())->match('locatorFoo'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithQueryContainerButQueryContainerInString(): void
    {
        $this->assertFalse((new QueryContainerLocatorMatcher())->match('locatorQueryContainer'));
    }
}
