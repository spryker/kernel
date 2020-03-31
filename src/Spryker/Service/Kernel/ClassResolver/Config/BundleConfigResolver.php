<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Service\Kernel\ClassResolver\Config;

use Spryker\Service\Kernel\ClassResolver\AbstractClassResolver;

class BundleConfigResolver extends AbstractClassResolver
{
    protected const RESOLVABLE_TYPE = 'ServiceConfig';

    /**
     * @param object|string $callerClass
     *
     * @throws \Spryker\Service\Kernel\ClassResolver\Config\BundleConfigNotFoundException
     *
     * @return \Spryker\Service\Kernel\AbstractBundleConfig
     */
    public function resolve($callerClass)
    {
        /** @var \Spryker\Service\Kernel\AbstractBundleConfig $resolved */
        $resolved = $this->doResolve($callerClass);

        if ($resolved !== null) {
            return $resolved;
        }

        throw new BundleConfigNotFoundException($this->getClassInfo());
    }

    /**
     * @return string
     */
    public function getClassPattern()
    {
        return sprintf(
            self::CLASS_NAME_PATTERN,
            self::KEY_NAMESPACE,
            self::KEY_BUNDLE,
            static::KEY_CODE_BUCKET
        );
    }
}
