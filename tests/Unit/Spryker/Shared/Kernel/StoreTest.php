<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Shared\Kernel;

use Spryker\Shared\Kernel\Store;

/**
 * @group Unit
 * @group Spryker
 * @group Shared
 * @group Kernel
 * @group StoreTest
 */
class StoreTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    private $Store;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Store = Store::getInstance();

        $locales = $this->Store->getLocales();
        if (!in_array('de_DE', $locales)) {
            $this->markTestSkipped('These tests require `de_DE` as part of the current whitelisted locales.');

            return;
        }

        $this->Store->setCurrentLocale('de_DE');
    }

    /**
     * @return void
     */
    public function testInstance()
    {
        $this->assertInstanceOf('\Spryker\Shared\Kernel\Store', $this->Store);
    }

    /**
     * @return void
     */
    public function testGetLocales()
    {
        $locales = $this->Store->getLocales();
        $this->assertSame($locales['de'], 'de_DE');
    }

    /**
     * @return void
     */
    public function testSetCurrentLocale()
    {
        $locale = $this->Store->getCurrentLocale();
        $this->assertSame('de_DE', $locale);

        $newLocale = 'en_US';
        $this->Store->setCurrentLocale($newLocale);

        $locale = $this->Store->getCurrentLocale();
        $this->assertSame($newLocale, $locale);
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @return void
     */
    public function testSetCurrentLocaleInvalid()
    {
        $newLocale = 'xy_XY';
        $this->Store->setCurrentLocale($newLocale);
    }

}
