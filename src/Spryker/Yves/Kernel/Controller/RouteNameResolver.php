<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Yves\Kernel\Controller;

use Spryker\Shared\Kernel\Communication\RouteNameResolverInterface;

class RouteNameResolver implements RouteNameResolverInterface
{

    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function resolve()
    {
        return $this->path;
    }

}
