<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Kernel;

use Spryker\Client\Kernel\ClientLocator;
use Spryker\Service\Kernel\ServiceLocator;
use Spryker\Shared\Kernel\AbstractLocatorLocator;
use Spryker\Shared\Kernel\BundleProxy;

class Locator extends AbstractLocatorLocator
{
    /**
     * @var static
     */
    private static $instance;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Should be private, because this class uses `Singleton` pattern.
     */
    private function __construct()
    {
    }

    /**
     * @return \Spryker\Shared\Kernel\BundleProxy
     */
    protected function getBundleProxy()
    {
        $bundleProxy = new BundleProxy();
        $bundleProxy
            ->addLocator(new ClientLocator())
            ->addLocator(new ServiceLocator());

        return $bundleProxy;
    }
}
