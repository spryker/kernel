<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\Container;

use Spryker\Service\Container\ContainerInterface;

interface GlobalContainerInterface
{
    public static function setContainer(ContainerInterface $container): void;

    public function getContainer(): ContainerInterface;

    public function has(string $id): bool;

    public function get(string $id): mixed;
}
