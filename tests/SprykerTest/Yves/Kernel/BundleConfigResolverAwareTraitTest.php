<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Yves\Kernel;

use Codeception\Test\Unit;
use Spryker\Yves\Kernel\AbstractBundleConfig;
use Spryker\Yves\Kernel\BundleConfigResolverAwareTrait;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Yves
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
     * @return \Spryker\Yves\Kernel\BundleConfigResolverAwareTrait|object
     */
    private function getBundleConfigResolverAwareTraitMock()
    {
        // Create a tiny concrete object that uses the trait instead of relying on PHPUnit's getMockForTrait()
        return new class {
            use BundleConfigResolverAwareTrait;
        };
    }

    /**
     * @return \Spryker\Yves\Kernel\AbstractBundleConfig
     */
    private function getAbstractBundleConfigMock(): AbstractBundleConfig
    {
        return new class extends AbstractBundleConfig {
        };
    }
}
