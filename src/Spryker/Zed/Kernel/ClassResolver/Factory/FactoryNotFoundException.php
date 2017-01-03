<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel\ClassResolver\Factory;

use Exception;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Exception\Backtrace;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Zed\Kernel\ClassResolver\ClassInfo;

class FactoryNotFoundException extends Exception
{

    /**
     * @param \Spryker\Zed\Kernel\ClassResolver\ClassInfo $callerClassInfo
     */
    public function __construct(ClassInfo $callerClassInfo)
    {
        parent::__construct($this->buildMessage($callerClassInfo));
    }

    /**
     * @param \Spryker\Zed\Kernel\ClassResolver\ClassInfo $callerClassInfo
     *
     * @return string
     */
    protected function buildMessage(ClassInfo $callerClassInfo)
    {
        $message = 'Spryker Kernel Exception' . PHP_EOL;
        $message .= sprintf(
            'Can not resolve %2$s%1$sFactory in %s layer for your bundle "%s"',
            $callerClassInfo->getLayer(),
            $callerClassInfo->getBundle()
        ) . PHP_EOL;

        $message .= 'You can fix this by adding the missing Factory to your bundle.' . PHP_EOL;

        $message .= sprintf(
            'E.g. %1$s\\Zed\\%2$s\\%3$s\\%2$s%3$sFactory' . PHP_EOL . PHP_EOL,
            Config::getInstance()->get(KernelConstants::PROJECT_NAMESPACE),
            $callerClassInfo->getBundle(),
            $callerClassInfo->getLayer()
        );

        $message .= new Backtrace();

        return $message;
    }

}
