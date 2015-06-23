<?php
/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace SprykerEngine\Yves\Kernel\Communication;

use SprykerEngine\Shared\Kernel\AbstractFactory;

class Factory extends AbstractFactory
{

    /**
     * @var string
     */
    protected $classNamePattern = '\\{{namespace}}\\Yves\\{{bundle}}{{store}}\\Communication\\';

    /**
     * @param string $class
     *
     * @return object
     * @throws \Exception
     */
    public function create($class)
    {
        $arguments = func_get_args();
        array_shift($arguments);

        $class = $this->buildClassName($class);
        $resolver = $this->getResolver();

        return $resolver->resolve($class, $this->getBundle(), $arguments);
    }

}
