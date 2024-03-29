<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel;

use Spryker\Shared\Kernel\ClassResolver\ClassNameCandidatesBuilder\ClassNameCandidatesBuilder;
use Spryker\Shared\Kernel\ClassResolver\ClassNameCandidatesBuilder\ClassNameCandidatesBuilderInterface;
use Spryker\Shared\Kernel\ClassResolver\ClassNameFinder\ClassNameFinder;
use Spryker\Shared\Kernel\ClassResolver\ClassNameFinder\ClassNameFinderInterface;
use Spryker\Shared\Kernel\ClassResolver\ModuleNameCandidatesBuilder\ModuleNameCandidatesBuilder;
use Spryker\Shared\Kernel\ClassResolver\ModuleNameCandidatesBuilder\ModuleNameCandidatesBuilderInterface;
use Spryker\Shared\Kernel\ClassResolver\ModuleNamePostfixProvider\ModuleNamePostfixProvider;
use Spryker\Shared\Kernel\ClassResolver\ModuleNamePostfixProvider\ModuleNamePostfixProviderInterface;
use Spryker\Shared\Kernel\ClassResolver\ResolverCacheFactoryInterface;
use Spryker\Shared\Kernel\ClassResolver\ResolverCacheManager;
use Spryker\Shared\Kernel\CodeBucket\Config\CodeBucketConfig;
use Spryker\Shared\Kernel\CodeBucket\Config\CodeBucketConfigInterface;

/**
 * @method \Spryker\Shared\Kernel\KernelConfig getSharedConfig()
 */
class KernelSharedFactory extends AbstractSharedFactory
{
    /**
     * @return \Spryker\Shared\Kernel\ClassResolver\ClassNameFinder\ClassNameFinderInterface
     */
    public function createClassNameFinder(): ClassNameFinderInterface
    {
        return new ClassNameFinder(
            $this->createClassNameCandidatesBuilder(),
            $this->createResolverCacheManager(),
        );
    }

    /**
     * @return \Spryker\Shared\Kernel\ClassResolver\ResolverCacheFactoryInterface
     */
    public function createResolverCacheManager(): ResolverCacheFactoryInterface
    {
        return new ResolverCacheManager();
    }

    /**
     * @return \Spryker\Shared\Kernel\ClassResolver\ClassNameCandidatesBuilder\ClassNameCandidatesBuilderInterface
     */
    public function createClassNameCandidatesBuilder(): ClassNameCandidatesBuilderInterface
    {
        return new ClassNameCandidatesBuilder($this->createModuleNameCandidatesBuilder(), $this->getSharedConfig());
    }

    /**
     * @return \Spryker\Shared\Kernel\ClassResolver\ModuleNameCandidatesBuilder\ModuleNameCandidatesBuilderInterface
     */
    public function createModuleNameCandidatesBuilder(): ModuleNameCandidatesBuilderInterface
    {
        return new ModuleNameCandidatesBuilder($this->createModuleNamePostfixProvider());
    }

    /**
     * @return \Spryker\Shared\Kernel\ClassResolver\ModuleNamePostfixProvider\ModuleNamePostfixProviderInterface
     */
    public function createModuleNamePostfixProvider(): ModuleNamePostfixProviderInterface
    {
        return new ModuleNamePostfixProvider(
            $this->getSharedConfig(),
            $this->createCodeBucketConfig(),
        );
    }

    /**
     * @return \Spryker\Shared\Kernel\CodeBucket\Config\CodeBucketConfigInterface
     */
    public function createCodeBucketConfig(): CodeBucketConfigInterface
    {
        return new CodeBucketConfig();
    }
}
