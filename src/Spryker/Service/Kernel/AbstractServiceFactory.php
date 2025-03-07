<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Service\Kernel;

use Spryker\Service\Kernel\ClassResolver\DependencyProvider\DependencyProviderResolver;
use Spryker\Service\Kernel\Exception\Container\ContainerKeyNotFoundException;
use Spryker\Shared\Kernel\ContainerMocker\ContainerMocker;

class AbstractServiceFactory
{
    use BundleConfigResolverAwareTrait;
    use ContainerMocker;

    /**
     * Specification:
     * - Defines the default behavior of service loading.
     * - The service is resolved immediately as part of fetching.
     *
     * @var string
     */
    public const LOADING_EAGER = 'LOADING_EAGER';

    /**
     * Specification:
     * - Defines the optional behavior of service loading.
     * - The service is resolved later, when it is actually needed.
     *
     * @var string
     */
    public const LOADING_LAZY = 'LOADING_LAZY';

    /**
     * @var array<\Spryker\Service\Kernel\Container>
     */
    protected static $containers = [];

    /**
     * @param \Spryker\Service\Kernel\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container)
    {
        static::$containers[static::class] = $container;

        return $this;
    }

    /**
     * @param string $key
     * @param string $fetch The `LOADING_LAZY` behavior returns the service as closure for later resolving.
     *
     * @throws \Spryker\Service\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return mixed
     */
    public function getProvidedDependency($key, $fetch = self::LOADING_EAGER)
    {
        $container = $this->getContainer();

        if ($container->has($key) === false) {
            throw new ContainerKeyNotFoundException($this, $key);
        }

        if ($fetch === static::LOADING_LAZY) {
            return fn () => $container->get($key);
        }

        return $container->get($key);
    }

    /**
     * @return \Spryker\Service\Kernel\Container
     */
    protected function getContainer(): Container
    {
        $containerKey = static::class;

        if (!isset(static::$containers[$containerKey])) {
            static::$containers[$containerKey] = $this->createContainerWithProvidedDependencies();
        }

        return static::$containers[$containerKey];
    }

    /**
     * @return \Spryker\Service\Kernel\Container
     */
    protected function createContainerWithProvidedDependencies()
    {
        $container = $this->createContainer();
        $dependencyProvider = $this->resolveDependencyProvider();

        $this->provideExternalDependencies($dependencyProvider, $container);

        /** @var \Spryker\Service\Kernel\Container $container */
        $container = $this->overwriteForTesting($container);

        return $container;
    }

    /**
     * @return \Spryker\Service\Kernel\Container
     */
    protected function createContainer()
    {
        $container = new Container();

        return $container;
    }

    /**
     * @return \Spryker\Service\Kernel\AbstractBundleDependencyProvider
     */
    protected function resolveDependencyProvider()
    {
        return $this->createDependencyProviderResolver()->resolve($this);
    }

    /**
     * @param \Spryker\Service\Kernel\AbstractBundleDependencyProvider $dependencyProvider
     * @param \Spryker\Service\Kernel\Container $container
     *
     * @return void
     */
    protected function provideExternalDependencies(
        AbstractBundleDependencyProvider $dependencyProvider,
        Container $container
    ) {
        $dependencyProvider->provideServiceDependencies($container);
    }

    /**
     * @return \Spryker\Service\Kernel\ClassResolver\DependencyProvider\DependencyProviderResolver
     */
    protected function createDependencyProviderResolver()
    {
        return new DependencyProviderResolver();
    }
}
