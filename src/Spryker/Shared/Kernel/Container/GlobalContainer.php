<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\Container;

use RuntimeException;
use Spryker\Service\Container\ContainerInterface;

class GlobalContainer implements GlobalContainerInterface
{
    /**
     * @var \Spryker\Service\Container\ContainerInterface
     */
    protected static $container;

    public static function setContainer(ContainerInterface $container): void
    {
        static::$container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        if (static::$container === null) {
            throw new RuntimeException('GlobalContainer has not been initialized. Call GlobalContainer::setContainer() first.');
        }

        return static::$container;
    }

    public function has(string $id): bool
    {
        if (static::$container === null) {
            return false;
        }

        return static::$container->has($id);
    }

    public function get(string $id): mixed
    {
        if (static::$container === null) {
            throw new RuntimeException('GlobalContainer has not been initialized. Call GlobalContainer::setContainer() first.');
        }

        return static::$container->get($id);
    }
}
