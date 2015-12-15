<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel\Communication\Controller;

interface ControllerExtensionInterface
{

    /**
     * @param $controller
     *
     * @return mixed
     */
    public function extend($controller);

}
