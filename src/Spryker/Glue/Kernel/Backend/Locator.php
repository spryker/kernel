<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel\Backend;

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

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function getBundleProxy(): BundleProxy
    {
        $bundleProxy = new BundleProxy();
        if ($this->locator === null) {
            $this->locator = [
                new FacadeLocator(),
                new ClientLocator(),
                new ResourceLocator(),
                new ServiceLocator(),
                new QueryContainerLocator(),
            ];
        }
        $bundleProxy->setLocators($this->locator);

        return $bundleProxy;
    }
}
