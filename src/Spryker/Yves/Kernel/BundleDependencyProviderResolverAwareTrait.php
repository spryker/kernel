<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Kernel;

use Spryker\Shared\Kernel\ContainerGlobals;
use Spryker\Shared\Kernel\ContainerMocker\ContainerMocker;
use Spryker\Yves\Kernel\ClassResolver\DependencyInjector\DependencyInjectorResolver;
use Spryker\Yves\Kernel\ClassResolver\DependencyProvider\DependencyProviderResolver;
use Spryker\Yves\Kernel\Dependency\Injector\DependencyInjector;
use Spryker\Yves\Kernel\Dependency\Injector\DependencyInjectorCollectionInterface;
use Spryker\Yves\Kernel\Dependency\Injector\DependencyInjectorInterface;
use Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException;

trait BundleDependencyProviderResolverAwareTrait
{
    use ContainerMocker;

    /**
     * @var \Spryker\Yves\Kernel\Container
     */
    protected $container;

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param string $key
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return mixed
     */
    public function getProvidedDependency(string $key)
    {
        if ($this->container === null) {
            $this->container = $this->createContainerWithProvidedDependencies();
        }

        if ($this->container->has($key) === false) {
            throw new ContainerKeyNotFoundException($this, $key);
        }

        return $this->container->get($key);
    }

    protected function createContainerWithProvidedDependencies(): Container
    {
        $container = $this->createContainer();
        $dependencyInjectorCollection = $this->resolveDependencyInjectorCollection();
        $dependencyInjector = $this->createDependencyInjector($dependencyInjectorCollection);
        $dependencyProvider = $this->resolveDependencyProvider();

        $this->provideExternalDependencies($dependencyProvider, $container);
        $this->injectExternalDependencies($dependencyInjector, $container);

        /** @var \Spryker\Yves\Kernel\Container $container */
        $container = $this->overwriteForTesting($container);

        return $container;
    }

    protected function createDependencyInjector(DependencyInjectorCollectionInterface $dependencyInjectorCollection): DependencyInjectorInterface
    {
        return new DependencyInjector($dependencyInjectorCollection);
    }

    protected function resolveDependencyProvider(): AbstractBundleDependencyProvider
    {
        return $this->createDependencyProviderResolver()->resolve($this);
    }

    protected function createDependencyProviderResolver(): DependencyProviderResolver
    {
        return new DependencyProviderResolver();
    }

    abstract protected function provideExternalDependencies(
        AbstractBundleDependencyProvider $dependencyProvider,
        Container $container
    ): Container;

    abstract protected function injectExternalDependencies(
        DependencyInjector $dependencyInjector,
        Container $container
    ): Container;

    protected function createContainer(): Container
    {
        $containerGlobals = $this->createContainerGlobals();
        $container = new Container($containerGlobals->getContainerGlobals());

        return $container;
    }

    protected function createContainerGlobals(): ContainerGlobals
    {
        return new ContainerGlobals();
    }

    protected function resolveDependencyInjectorCollection(): DependencyInjectorCollectionInterface
    {
        return $this->createDependencyInjectorResolver()->resolve($this);
    }

    protected function createDependencyInjectorResolver(): DependencyInjectorResolver
    {
        return new DependencyInjectorResolver();
    }
}
