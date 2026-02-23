<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Kernel;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use Spryker\Zed\Kernel\BundleConfigResolverAwareTrait;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group Kernel
 * @group BundleConfigResolverAwareTraitTest
 * Add your own group annotations below this line
 */
class BundleConfigResolverAwareTraitTest extends Unit
{
    /**
     * @return void
     */
    public function testSetConfigMustReturnFluentInterface(): void
    {
        $bundleConfigResolverAwareTraitMock = $this->getBundleConfigResolverAwareTraitMock();
        $returned = $bundleConfigResolverAwareTraitMock->setConfig(
            $this->getAbstractBundleConfigMock(),
        );

        $this->assertSame($bundleConfigResolverAwareTraitMock, $returned);
    }

    /**
     * @return \Spryker\Zed\Kernel\BundleConfigResolverAwareTrait|object
     */
    private function getBundleConfigResolverAwareTraitMock()
    {
        // Create a tiny concrete object that uses the trait instead of relying on PHPUnit's getMockForTrait()
        return new class {
            use BundleConfigResolverAwareTrait;
        };
    }

    /**
     * @return \Spryker\Zed\Kernel\AbstractBundleConfig
     */
    private function getAbstractBundleConfigMock(): AbstractBundleConfig
    {
        // Create a minimal concrete subclass of the abstract config to avoid getMockForAbstractClass()
        return new class extends AbstractBundleConfig {
        };
    }
}
