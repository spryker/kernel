<?php

namespace Unit\SprykerEngine\Shared\Kernel\Fixtures;

use SprykerEngine\Shared\Kernel\AbstractLocatorLocator;
use SprykerEngine\Shared\Kernel\BundleProxy;

class LocatorLocator extends AbstractLocatorLocator
{

    protected function getBundleProxy()
    {
        return new BundleProxy($this);
    }
}
