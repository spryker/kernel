<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Shared\Kernel\ClassResolver;

use Codeception\Stub;
use Codeception\Test\Unit;
use Spryker\Shared\Kernel\ClassResolver\ResolvableCache\CacheReader\CacheReaderPhp;
use Spryker\Shared\Kernel\KernelConfig;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Shared
 * @group Kernel
 * @group ClassResolver
 * @group CacheReaderPhpTest
 * Add your own group annotations below this line
 */
class CacheReaderPhpTest extends Unit
{
    /**
     * @var \SprykerTest\Shared\Kernel\KernelSharedTester
     */
    protected $tester;

    /**
     * During environment build the cache file has not been generated yet.
     * CacheReaderPhp::read() must return an empty array silently — no E_USER_DEPRECATED.
     *
     * Fails currently because the implementation unconditionally calls trigger_error()
     * when the file is missing instead of falling back gracefully.
     */
    public function testReadReturnsEmptyArrayWithoutDeprecationWhenCacheFileDoesNotExist(): void
    {
        $nonExistentPath = sprintf('/tmp/non_existent_cache_%s.php', uniqid());
        $pathPattern = $nonExistentPath . '%s';

        /** @var \Spryker\Shared\Kernel\KernelConfig $configStub */
        $configStub = Stub::make(KernelConfig::class, [
            'getResolvableCacheFilePathPattern' => function () use ($pathPattern): string {
                return $pathPattern;
            },
        ]);

        $deprecationTriggered = false;
        set_error_handler(function (int $errno) use (&$deprecationTriggered): bool {
            if ($errno === E_USER_DEPRECATED) {
                $deprecationTriggered = true;
            }

            return true;
        });

        $result = (new CacheReaderPhp($configStub))->read();

        restore_error_handler();

        $this->assertFalse($deprecationTriggered, 'CacheReaderPhp must not trigger E_USER_DEPRECATED when the cache file has not been generated yet.');
        $this->assertSame([], $result);
    }

    public function testReadReturnsCacheDataWhenFileExists(): void
    {
        $expectedData = ['FooBarZedFacade' => '\Spryker\Zed\FooBar\Business\FooBarFacade'];
        $pathPattern = sprintf('/tmp/resolvable_cache_test_%s%%s.php', uniqid());
        $actualPath = sprintf($pathPattern, APPLICATION_CODE_BUCKET);

        file_put_contents($actualPath, '<?php return ' . var_export($expectedData, true) . ';');

        /** @var \Spryker\Shared\Kernel\KernelConfig $configStub */
        $configStub = Stub::make(KernelConfig::class, [
            'getResolvableCacheFilePathPattern' => function () use ($pathPattern): string {
                return $pathPattern;
            },
        ]);

        $result = (new CacheReaderPhp($configStub))->read();

        unlink($actualPath);

        $this->assertSame($expectedData, $result);
    }
}
