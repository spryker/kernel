<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\ClassResolver\ModuleNamePostfixProvider;

interface ModuleNamePostfixProviderInterface
{
    public function getCurrentModuleNamePostfix(): string;

    /**
     * @return array<string>
     */
    public function getAvailableModuleNamePostfixes(): array;
}
