<?php

namespace SprykerEngine\Zed\Kernel\Communication;

use SprykerEngine\Shared\Kernel\Locator\LocatorMatcherInterface;

class ConsoleLocatorMatcher implements LocatorMatcherInterface
{

    const METHOD_PREFIX = 'console';

    /**
     * @param string $method
     *
     * @return bool
     */
    public function match($method)
    {
        return (strpos($method, self::METHOD_PREFIX) === 0);
    }

    /**
     * @param string $method
     *
     * @return string
     */
    public function filter($method)
    {
        return substr($method, strlen(self::METHOD_PREFIX));
    }

}
