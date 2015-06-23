<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerEngine\Zed\Kernel\Communication;

use SprykerEngine\Shared\Kernel\AbstractFactory;
use SprykerEngine\Zed\Kernel\BundleConfigLocator;

class Factory extends AbstractFactory
{

    /**
     * @var string
     */
    protected $classNamePattern = '\\{{namespace}}\\Zed\\{{bundle}}{{store}}\\Communication\\';

    /**
     * @param string $class
     *
     * @return object
     * @throws \Exception
     */
    public function create($class)
    {
        $arguments = func_get_args();

        if (in_array($class, $this->baseClasses)) {
            $bundleConfigLocator = new BundleConfigLocator();
            $bundleConfig = $bundleConfigLocator->locate($this->getBundle(), $arguments[2]);

            $arguments[] = $bundleConfig;
        }

        array_shift($arguments);

        if ($this->isMagicCall) {
            $arguments = (count($arguments) > 0) ? $arguments[0] : [];
        }
        $this->isMagicCall = false;

        $class = $this->buildClassName($class);
        $resolver = $this->getResolver();

        return $resolver->resolve($class, $this->getBundle(), $arguments);
    }
}
