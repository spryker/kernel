<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Kernel\Dependency\Widget;

use ArrayAccess;
use Spryker\Yves\Kernel\Widget\WidgetContainerInterface;

/**
 * @extends \ArrayAccess<int|string, mixed>
 */
interface WidgetInterface extends WidgetContainerInterface, ArrayAccess
{
    public static function getName(): string;

    public static function getTemplate(): string;

    public function getParameters(): array;
}
