<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Kernel;

use Spryker\Shared\Kernel\Validator\RedirectUrlValidator;
use Spryker\Shared\Kernel\Validator\RedirectUrlValidatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method \Spryker\Yves\Kernel\KernelConfig getConfig()
 */
class KernelFactory extends AbstractFactory
{
    public function createRedirectUrlValidator(): RedirectUrlValidatorInterface
    {
        return new RedirectUrlValidator(
            $this->createValidator(),
            $this->getConfig()->getDomainsAllowedForRedirect(),
            $this->getConfig()->isStrictDomainRedirectEnabled(),
        );
    }

    public function createValidator(): ValidatorInterface
    {
        return Validation::createValidator();
    }
}
