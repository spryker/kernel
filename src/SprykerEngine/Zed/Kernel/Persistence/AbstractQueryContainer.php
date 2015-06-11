<?php

namespace SprykerEngine\Zed\Kernel\Persistence;

use SprykerEngine\Zed\Kernel\Container;
use SprykerEngine\Zed\Kernel\Locator;
use SprykerEngine\Zed\Kernel\Persistence\DependencyContainer\DependencyContainerInterface;
use SprykerEngine\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

abstract class AbstractQueryContainer implements QueryContainerInterface
{

    /**
     * @var DependencyContainerInterface
     */
    private $dependencyContainer;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * External dependencies
     * @var Container
     */
    private $container;

    /**
     * @param Factory $factory
     * @param Locator $locator
     */
    public function __construct(Factory $factory, Locator $locator)
    {
        $this->factory = $factory;

        if ($factory->exists('DependencyContainer')) {
            $this->dependencyContainer = $factory->create('DependencyContainer', $factory, $locator);
        }
    }

    /**
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $key
     * @return mixed
     *
     * @throws \ErrorException
     */
    public function getInjectedDependency($key)
    {
        if (false === $this->container->offsetExists($key)) {
            throw new \ErrorException("Key $key does not exist in container.");
        }

        return $this->container[$key];
    }

    /**
     * @return Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * TODO Will be removed.
     * @deprecated
     * @return DependencyContainerInterface
     */
    protected function getDependencyContainer()
    {
        return $this->dependencyContainer;
    }
}
