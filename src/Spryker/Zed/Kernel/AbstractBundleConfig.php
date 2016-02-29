<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel;

use Spryker\Shared\Config\Config;

abstract class AbstractBundleConfig
{

    /**
     * @param string $key
     * @param mixed $default
     *
     * @throws \Exception
     *
     * @return mixed
     */
    protected function get($key, $default = null)
    {
        return $this->getConfig()->get($key, $default);
    }

    /**
     * @return \Spryker\Shared\Config
     */
    protected function getConfig()
    {
        return Config::getInstance();
    }

}
