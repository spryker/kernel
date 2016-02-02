<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Unit\Spryker\Zed\Kernel;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use Spryker\Zed\Kernel\BundleConfigResolverAwareTrait;

/**
 * @group Spryker
 * @group Zed
 * @group Kernel
 * @group BundleConfigResolverAwareTrait
 */
class BundleConfigResolverAwareTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testSetConfigMustReturnFluentInterface()
    {
        $bundleConfigResolverAwareTraitMock = $this->getBundleConfigResolverAwareTraitMock();
        $returned = $bundleConfigResolverAwareTraitMock->setConfig(
            $this->getAbstractBundleConfigMock()
        );

        $this->assertSame($bundleConfigResolverAwareTraitMock, $returned);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Kernel\BundleConfigResolverAwareTrait
     */
    private function getBundleConfigResolverAwareTraitMock()
    {
        return $this->getMockForTrait(BundleConfigResolverAwareTrait::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Kernel\AbstractBundleConfig
     */
    private function getAbstractBundleConfigMock()
    {
        return $this->getMockForAbstractClass(AbstractBundleConfig::class);
    }

}
