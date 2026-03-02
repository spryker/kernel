<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel\Communication\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\Kernel\Business\KernelFacadeInterface getFacade()
 * @method \Spryker\Zed\Kernel\Communication\KernelCommunicationFactory getFactory()
 */
class ResolvableClassCacheConsole extends Console
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'cache:class-resolver:build';

    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->isSupportedPhpVersion()) {
            $this->info('This command only works with PHP version 7.3 or higher.');

            return static::CODE_SUCCESS;
        }

        $this->getFacade()->buildResolvableClassCache();

        return static::CODE_SUCCESS;
    }

    protected function isSupportedPhpVersion(): bool
    {
        return PHP_VERSION_ID >= 70300;
    }
}
