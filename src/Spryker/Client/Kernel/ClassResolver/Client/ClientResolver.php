<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Kernel\ClassResolver\Client;

use Spryker\Client\Kernel\ClassResolver\AbstractClassResolver;

class ClientResolver extends AbstractClassResolver
{
    protected const RESOLVABLE_TYPE = 'ClientClient';

    /**
     * @param object|string $callerClass
     *
     * @throws \Spryker\Client\Kernel\ClassResolver\Client\ClientNotFoundException
     *
     * @return \Spryker\Client\Kernel\AbstractClient
     */
    public function resolve($callerClass)
    {
        /** @var \Spryker\Client\Kernel\AbstractClient $resolved */
        $resolved = $this->doResolve($callerClass);

        if ($resolved !== null) {
            return $resolved;
        }

        throw new ClientNotFoundException($this->getClassInfo());
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
