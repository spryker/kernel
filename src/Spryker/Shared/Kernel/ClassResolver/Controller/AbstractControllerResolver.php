<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Shared\Kernel\ClassResolver\Controller;

use Spryker\Shared\Kernel\ClassResolver\AbstractClassResolver;
use Spryker\Shared\Kernel\Communication\BundleControllerActionInterface;

abstract class AbstractControllerResolver extends AbstractClassResolver
{

    const KEY_CONTROLLER = '%controller%';

    /**
     * @var \Spryker\Shared\Kernel\Communication\BundleControllerActionInterface
     */
    protected $bundleControllerAction;

    /**
     * @param \Spryker\Shared\Kernel\Communication\BundleControllerActionInterface $bundleControllerAction
     *
     * @throws \Spryker\Shared\Kernel\ClassResolver\Controller\ControllerNotFoundException
     *
     * @return object
     */
    public function resolve(BundleControllerActionInterface $bundleControllerAction)
    {
        $this->bundleControllerAction = $bundleControllerAction;
        if ($this->canResolve()) {
            return $this->getResolvedClassInstance();
        }

        throw new ControllerNotFoundException($bundleControllerAction);
    }

    /**
     * @param \Spryker\Shared\Kernel\Communication\BundleControllerActionInterface $bundleControllerAction
     *
     * @return bool
     */
    public function isResolveAble(BundleControllerActionInterface $bundleControllerAction)
    {
        $this->bundleControllerAction = $bundleControllerAction;
        if ($this->canResolve()) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getClassPattern()
    {
        return sprintf(
            $this->getClassNamePattern(),
            self::KEY_NAMESPACE,
            self::KEY_BUNDLE,
            self::KEY_STORE,
            self::KEY_CONTROLLER
        );
    }

    /**
     * @return mixed
     */
    abstract protected function getClassNamePattern();

    /**
     * @param string $namespace
     * @param string|null $store
     *
     * @return string
     */
    protected function buildClassName($namespace, $store = null)
    {
        $searchAndReplace = [
            self::KEY_NAMESPACE => $namespace,
            self::KEY_BUNDLE => $this->bundleControllerAction->getBundle(),
            self::KEY_STORE => $store,
            self::KEY_CONTROLLER => $this->bundleControllerAction->getController(),
        ];

        $className = str_replace(
            array_keys($searchAndReplace),
            array_values($searchAndReplace),
            $this->getClassPattern()
        );

        return $className;
    }

}
