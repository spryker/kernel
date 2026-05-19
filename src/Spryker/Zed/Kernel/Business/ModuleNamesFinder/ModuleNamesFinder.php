<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel\Business\ModuleNamesFinder;

use Spryker\Zed\Kernel\KernelConfig;
use Symfony\Component\Finder\Finder;

class ModuleNamesFinder implements ModuleNamesFinderInterface
{
    /**
     * @var \Spryker\Zed\Kernel\KernelConfig
     */
    protected $config;

    public function __construct(KernelConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return array<string>
     */
    public function findModuleNames(): array
    {
        $moduleNames = [];

        $moduleNames = $this->addProjectModuleNames($moduleNames);
        $moduleNames = $this->addCoreModuleNames($moduleNames);

        ksort($moduleNames);

        return $moduleNames;
    }

    /**
     * @param array<string> $moduleNames
     *
     * @return array<string>
     */
    protected function addProjectModuleNames(array $moduleNames): array
    {
        $finder = new Finder();
        $finder->directories()->depth(0)->in($this->config->getPathsToProjectModules());

        foreach ($finder as $splFileInfo) {
            $moduleNames[$splFileInfo->getFilename()] = $splFileInfo->getFilename();
        }

        return $moduleNames;
    }

    /**
     * @param array<string> $moduleNames
     *
     * @return array<string>
     */
    protected function addCoreModuleNames(array $moduleNames): array
    {
        $existingPaths = $this->filterExistingPaths($this->config->getPathsToCoreModules());

        if ($existingPaths === []) {
            return $moduleNames;
        }

        $finder = new Finder();
        $finder->directories()->depth(0)->in($existingPaths);

        foreach ($finder as $splFileInfo) {
            $moduleNames[$splFileInfo->getFilename()] = $splFileInfo->getFilename();
        }

        return $moduleNames;
    }

    /**
     * @param array<string> $paths
     *
     * @return array<string>
     */
    protected function filterExistingPaths(array $paths): array
    {
        return array_values(array_filter($paths, static function (string $path): bool {
            $baseDir = rtrim(explode('*', $path)[0], '/');

            return is_dir($baseDir);
        }));
    }
}
