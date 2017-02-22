<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\Kernel\Communication\Controller;

use PHPUnit_Framework_TestCase;
use Unit\Spryker\Zed\Kernel\Communication\Controller\Fixtures\MockController;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Application
 * @group Communication
 * @group Controller
 * @group AbstractControllerTest
 */
class AbstractControllerTest extends PHPUnit_Framework_TestCase
{

    const EXPECTED_INTERNAL_TYPE = 'int';

    /**
     * @dataProvider getTestData()
     *
     * @param mixed $input
     * @param int $expected
     * @param bool $isValid
     *
     * @return void
     */
    public function testCastInt($input, $expected, $isValid)
    {
        $controller = new MockController();

        if (!$isValid) {
            $this->expectException(\Exception::class);
        }

        $result = $controller->indexAction($input);

        $this->assertSame($expected, $result);
        $this->assertInternalType(self::EXPECTED_INTERNAL_TYPE, $result);
    }

    /**
     * @return array
     */
    public function getTestData()
    {
        return [
            ['1', 1, true],
            [1, 1, true],
            [1.5, 1, true],
            [true, 1, false],
            [false, 0, false],
            ['string', 0, false],
            [[], 0, false],
        ];
    }

}
