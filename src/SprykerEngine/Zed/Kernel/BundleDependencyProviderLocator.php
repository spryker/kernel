<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel;

use Spryker\Shared\Kernel\Locator\LocatorException;
use Spryker\Shared\Kernel\LocatorLocatorInterface;
use Spryker\Shared\Kernel\AbstractLocator;

class BundleDependencyProviderLocator extends AbstractLocator
{

    const CLASS_NAME_SUFFIX = 'DependencyProvider';

    /**
     * @var string
     */
    protected $factoryClassNamePattern = '\\{{namespace}}\\Zed\\Kernel\\Factory';

    protected $bundle = 'Kernel';

    protected $layer = null;

    protected $suffix = 'Factory';

    protected $application = 'Zed';

    /**
     * @param string $bundle
     * @param LocatorLocatorInterface $locator
     * @param string|null $className
     *
     * @throws LocatorException
     *
     * @return BundleDependencyProviderInterface
     */
    public function locate($bundle, LocatorLocatorInterface $locator, $className = null)
    {
        $factory = $this->getFactory($bundle);
        $className = $bundle . self::CLASS_NAME_SUFFIX;

        return $factory->create($className);
    }

}
