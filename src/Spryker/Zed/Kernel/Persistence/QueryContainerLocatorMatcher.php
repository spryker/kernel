<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel\Persistence;

use Spryker\Shared\Kernel\Locator\LocatorMatcherInterface;

class QueryContainerLocatorMatcher implements LocatorMatcherInterface
{

    const METHOD_PREFIX = 'queryContainer';

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
        return '';
    }

}