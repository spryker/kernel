<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel;

use Spryker\Client\Kernel\ClientLocator;
use Spryker\Service\Kernel\ServiceLocator;
use Spryker\Shared\Kernel\AbstractLocatorLocator;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Business\FacadeLocator;
use Spryker\Zed\Kernel\Persistence\QueryContainerLocator;

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
        if ($this->locator === null) {
            $this->locator = [
                new FacadeLocator(),
                new QueryContainerLocator(),
                new ClientLocator(),
                new ServiceLocator(),
            ];
        }
        $bundleProxy->setLocators($this->locator);

        return $bundleProxy;
    }
}
