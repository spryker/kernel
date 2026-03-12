<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel;

use Generated\Shared\Transfer\ConfigurationValueRequestTransfer;
use Spryker\Shared\Kernel\AbstractBundleConfig as SharedAbstractBundleConfig;
use Spryker\Shared\Kernel\SharedConfigResolverAwareTrait;

abstract class AbstractBundleConfig extends SharedAbstractBundleConfig
{
    use SharedConfigResolverAwareTrait;

    /**
     * @param string $key
     * @param mixed|null $default
     * @param array<\Generated\Shared\Transfer\ConfigurationScopeTransfer> $configurationScopes
     *
     * @return mixed
     */
    protected function getModuleConfig(string $key, $default = null, array $configurationScopes = []): mixed
    {
        if (!interface_exists('\Spryker\Client\Configuration\ConfigurationClientInterface')) {
            return $default;
        }

        /** @var \Generated\Glue\Ide\AutoCompletion&\Spryker\Shared\Kernel\LocatorLocatorInterface $locator */
        $locator = Locator::getInstance();

        $requestTransfer = (new ConfigurationValueRequestTransfer())
            ->setKey($key);

        foreach ($configurationScopes as $configurationScopeTransfer) {
            $requestTransfer->addScope($configurationScopeTransfer);
        }

        $configValue = $locator->configuration()->client()->getConfigurationValue($requestTransfer);

        if ($configValue !== null) {
            return $configValue;
        }

        return $default;
    }
}
