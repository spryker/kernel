<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\Kernel\ClassResolver\RestResource;

use Spryker\Service\Kernel\ClassResolver\AbstractClassResolver;

class ResourceResolver extends AbstractClassResolver
{
    protected const RESOLVABLE_TYPE = 'GlueResource';

    /**
     * @param object|string $callerClass
     *
     * @throws \Spryker\Glue\Kernel\ClassResolver\RestResource\RestResourceNotFoundException
     *
     * @return \Spryker\Glue\Kernel\AbstractRestResource
     */
    public function resolve($callerClass)
    {
        /** @var \Spryker\Glue\Kernel\AbstractRestResource $resolved */
        $resolved = $this->doResolve($callerClass);

        if ($resolved !== null) {
            return $resolved;
        }

        throw new RestResourceNotFoundException($this->getClassInfo())
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
