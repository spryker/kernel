<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\Spryker\Zed\Kernel\Communication;

use PHPUnit_Framework_TestCase;
use Spryker\Zed\Kernel\Communication\BundleControllerAction;
use Symfony\Component\HttpFoundation\Request;

/**
 * @group Unit
 * @group Spryker
 * @group Zed
 * @group Kernel
 * @group Communication
 * @group BundleControllerActionTest
 */
class BundleControllerActionTest extends PHPUnit_Framework_TestCase
{

    const BUNDLE = 'foo';
    const CONTROLLER = 'bar';
    const ACTION = 'baz';

    /**
     * @return void
     */
    public function testGetBundleShouldReturnBundleNameFromRequest()
    {
        $bundleControllerAction = $this->getBundleControllerAction();

        $this->assertSame(self::BUNDLE, $bundleControllerAction->getBundle());
    }

    /**
     * @return void
     */
    public function testGetControllerShouldReturnControllerNameFromRequest()
    {
        $bundleControllerAction = $this->getBundleControllerAction();

        $this->assertSame(self::CONTROLLER, $bundleControllerAction->getController());
    }

    /**
     * @return void
     */
    public function testGetActionShouldReturnActionNameFromRequest()
    {
        $bundleControllerAction = $this->getBundleControllerAction();

        $this->assertSame(self::ACTION, $bundleControllerAction->getAction());
    }

    /**
     * @return \Spryker\Zed\Kernel\Communication\BundleControllerAction
     */
    private function getBundleControllerAction()
    {
        $request = $this->getRequestTestObject();
        $bundleControllerAction = new BundleControllerAction(
            $request->attributes->get('module'),
            $request->attributes->get('controller'),
            $request->attributes->get('action')
        );

        return $bundleControllerAction;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    private function getRequestTestObject()
    {
        $request = new Request(
            [],
            [],
            ['module' => self::BUNDLE, 'controller' => self::CONTROLLER, 'action' => self::ACTION]
        );

        return $request;
    }

}
