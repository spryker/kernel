<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Kernel\Business;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Business\FacadeLocatorMatcher;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Kernel
 * @group Business
 * @group Facade
 * @group FacadeLocatorMatcherTest
 * Add your own group annotations below this line
 */
class FacadeLocatorMatcherTest extends Unit
{
    public function testMatchShouldReturnTrueIfMethodStartsWithFacade(): void
    {
        $this->assertTrue((new FacadeLocatorMatcher())->match('facadeFoo'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithFacade(): void
    {
        $this->assertFalse((new FacadeLocatorMatcher())->match('locatorFoo'));
    }

    public function testMatchShouldReturnFalseIfMethodNotStartsWithFacadeButFacadeInString(): void
    {
        $this->assertFalse((new FacadeLocatorMatcher())->match('locatorFacade'));
    }
}
