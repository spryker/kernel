<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerEngine\Zed\Kernel\Business;

use SprykerEngine\Shared\Kernel\AbstractLocator;
use SprykerEngine\Shared\Kernel\ClassResolver\ClassNotFoundException;
use SprykerEngine\Shared\Kernel\Locator\LocatorException;
use SprykerEngine\Shared\Kernel\LocatorLocatorInterface;
use SprykerEngine\Zed\Kernel\BundleDependencyProviderLocator;
use SprykerEngine\Zed\Kernel\Container;
use SprykerFeature\Shared\Library\Log;

class FacadeLocator extends AbstractLocator
{

    const FACADE_SUFFIX = 'Facade';

    /**
     * @var string
     */
    protected $bundle = 'Kernel';

    /**
     * @var string
     */
    protected $layer = 'Business';

    /**
     * @var string
     */
    protected $application = 'Zed';

    /**
     * @var string
     */
    protected $suffix = 'Factory';

    /**
     * @param string $bundle
     * @param LocatorLocatorInterface $locator
     * @param string|null $className
     *
     * @throws LocatorException
     *
     * @return object
     */
    public function locate($bundle, LocatorLocatorInterface $locator, $className = null)
    {
        $factory = $this->getFactory($bundle);

        $facade = $factory->create($bundle . self::FACADE_SUFFIX);

        try {
            $bundleProviderLocator = new BundleDependencyProviderLocator(); // TODO Make singleton because of performance
            $bundleBuilder = $bundleProviderLocator->locate($bundle, $locator);

            $container = new Container();
            $bundleBuilder->provideBusinessLayerDependencies($container);
            $facade->setExternalDependencies($container);

            // TODO make lazy
            if ($locator->$bundle()->hasQueryContainer()) {
                $facade->setOwnQueryContainer($locator->$bundle()->queryContainer());
            }
        } catch (ClassNotFoundException $e) {
            // TODO remove try-catch when all bundles have a Builder
            Log::log(APPLICATION . ' - ' . $bundle, 'builder_missing.log');
        }

        return $facade;
    }

    /**
     * @param string $bundle
     *
     * @return bool
     */
    public function canLocate($bundle)
    {
        $factory = $this->getFactory($bundle);

        return $factory->exists($bundle . self::FACADE_SUFFIX);
    }

}
