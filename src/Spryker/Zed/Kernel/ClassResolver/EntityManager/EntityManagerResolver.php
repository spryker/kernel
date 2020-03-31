<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel\ClassResolver\EntityManager;

use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;

class EntityManagerResolver extends AbstractClassResolver
{
    protected const RESOLVABLE_TYPE = 'ZedEntityManager';

    /**
     * @param object|string $callerClass
     *
     * @throws \Spryker\Zed\Kernel\ClassResolver\EntityManager\EntityManagerNotFoundException
     *
     * @return \Spryker\Zed\Kernel\Persistence\AbstractEntityManager
     */
    public function resolve($callerClass)
    {
        /** @var \Spryker\Zed\Kernel\Persistence\AbstractEntityManager $resolved */
        $resolved = $this->doResolve($callerClass);

        if ($resolved !== null) {
            return $resolved;
        }

        throw new EntityManagerNotFoundException($this->getClassInfo());
    }

    /**
     * @return string
     */
    protected function getClassPattern()
    {
        return sprintf(
            self::CLASS_NAME_PATTERN,
            self::KEY_NAMESPACE,
            self::KEY_BUNDLE,
            static::KEY_CODE_BUCKET
        );
    }

    /**
     * @param string $namespace
     * @param string|null $codeBucket
     *
     * @return string
     */
    protected function buildClassName($namespace, $codeBucket = null)
    {
        $searchAndReplace = [
            self::KEY_NAMESPACE => $namespace,
            self::KEY_BUNDLE => $this->getClassInfo()->getBundle(),
            static::KEY_CODE_BUCKET => $codeBucket,
        ];

        return str_replace(
            array_keys($searchAndReplace),
            array_values($searchAndReplace),
            $this->getClassPattern()
        );
    }
}
