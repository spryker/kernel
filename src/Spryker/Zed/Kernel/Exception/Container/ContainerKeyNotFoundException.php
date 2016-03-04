<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel\Exception\Container;

use Spryker\Zed\Kernel\ClassResolver\ClassInfo;

class ContainerKeyNotFoundException extends \Exception
{

    /**
     * @param object $callerClass
     * @param string $key
     */
    public function __construct($callerClass, $key)
    {
        $classInfo = new ClassInfo();
        $classInfo->setClass($callerClass);

        parent::__construct($this->buildMessage($classInfo, $key));
    }

    /**
     * @param \Spryker\Zed\Kernel\ClassResolver\ClassInfo $callerClassInfo
     * @param string $key
     *
     * @return string
     */
    protected function buildMessage(ClassInfo $callerClassInfo, $key)
    {
        $message = 'Spryker Kernel Exception' . PHP_EOL;
        $message .= sprintf(
            'Container does not contain the called "%s"',
            $key
        ) . PHP_EOL;

        $message .= sprintf(
            'You can fix this by adding the key "%s" to your "%sDependencyProvider"',
            $key,
            $callerClassInfo->getBundle()
        );

        return $message;
    }

}
