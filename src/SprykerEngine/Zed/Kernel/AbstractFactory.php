<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel;

use Spryker\Shared\Kernel\ClassMapFactory;
use Spryker\Zed\Kernel\Factory\FactoryInterface;

abstract class AbstractFactory implements FactoryInterface
{

    const SUFFIX_FACTORY = self::FACTORY;
    const DEPENDENCY_CONTAINER = 'DependencyContainer';
    const FACTORY = 'Factory';

    /**
     * @var string
     */
    protected $bundle;

    /**
     * @var array
     */
    protected $baseClasses = [
        self::DEPENDENCY_CONTAINER,
        self::FACTORY,
    ];

    /**
     * @param string $class
     *
     * @return bool
     */
    public function exists($class)
    {
        if (in_array($class, $this->baseClasses)) {
            $class = $this->getBundle() . $class;
        }

        return ClassMapFactory::getInstance()->has('Zed', $this->getBundle(), $class);
    }

    /**
     * @return string
     */
    protected function getBundle()
    {
        if ($this->bundle === null) {
            $classNameParts = explode('\\', get_class($this));
            $bundleFactory = array_pop($classNameParts);

            $this->bundle = str_replace(self::SUFFIX_FACTORY, '', $bundleFactory);
        }

        return $this->bundle;
    }

}
