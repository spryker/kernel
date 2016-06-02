<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\ClassResolver;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\ClassResolver\Cache\ProviderInterface;

class ResolverCacheManager implements ResolverCacheFactoryInterface
{

    /**
     * @return bool
     */
    public function useCache()
    {
        return Config::hasValue(ApplicationConstants::AUTO_LOADER_UNRESOLVABLE_CACHE_ENABLED)
            && Config::get(ApplicationConstants::AUTO_LOADER_UNRESOLVABLE_CACHE_ENABLED, false);
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    protected function assertConfig()
    {
        if (!Config::hasValue(ApplicationConstants::AUTO_LOADER_UNRESOLVABLE_CACHE_PROVIDER)) {
            throw new \Exception(
                'Undefined UnresolvableCacheProvider. Make sure class exists and it\'s set in AUTO_LOADER_UNRESOLVABLE_CACHE_PROVIDER'
            );
        }
    }

    /**
     * @param \Spryker\Shared\Kernel\ClassResolver\Cache\ProviderInterface $cacheProvider
     *
     * @throws \Exception
     *
     * @return void
     */
    protected function assertProviderInterface($cacheProvider)
    {
        if (!($cacheProvider instanceof ProviderInterface)) {
            throw new \Exception(sprintf(
                'Class defined in AUTO_LOADER_UNRESOLVABLE_CACHE_PROVIDER "%s", must implement \Spryker\Shared\Kernel\ClassResolver\Cache\ProviderInterface'
            ));
        }
    }

    /**
     * @throws \Exception
     *
     * @return \Spryker\Shared\Kernel\ClassResolver\Cache\ProviderInterface
     */
    public function createClassResolverCacheProvider()
    {
        $this->assertConfig();

        $className = Config::get(ApplicationConstants::AUTO_LOADER_UNRESOLVABLE_CACHE_PROVIDER);

        $cacheProvider = new $className();

        $this->assertProviderInterface($cacheProvider);

        return $cacheProvider;
    }

}
