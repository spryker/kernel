<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\Kernel\Validator;

use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Yves\Kernel\Exception\ForbiddenExternalRedirectException;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class RedirectUrlValidator implements RedirectUrlValidatorInterface
{
    protected const HTTP_HEADER_LOCATION = 'Location';

    /**
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     *
     * @throws \Spryker\Yves\Kernel\Exception\ForbiddenExternalRedirectException
     *
     * @return void
     */
    public function validateRedirectUrl(FilterResponseEvent $event): void
    {
        $response = $event->getResponse();
        if (!$response->isRedirection()) {
            return;
        }

        $redirectUrl = $response->headers->get(static::HTTP_HEADER_LOCATION);
        $domain = (string)parse_url($redirectUrl, PHP_URL_HOST);
        $currentDomain = $event->getRequest()->getHost();

        if ($domain !== $currentDomain && !$this->isAllowedDomain($domain)) {
            throw new ForbiddenExternalRedirectException(sprintf('URL %s is not an allowed domain', $redirectUrl));
        }
    }

    /**
     * @see \Spryker\Shared\Kernel\KernelConstants::STRICT_DOMAIN_REDIRECT For strict redirection check status.
     * @see \Spryker\Shared\Kernel\KernelConstants::DOMAIN_WHITELIST For allowed list of external domains.
     *
     * @param string $domain
     *
     * @return bool
     */
    protected function isAllowedDomain(string $domain): bool
    {
        if (!$domain) {
            return true;
        }

        $allowedDomains = Config::get(KernelConstants::DOMAIN_WHITELIST, []);

        if (empty($allowedDomains)) {
            return !Config::get(KernelConstants::STRICT_DOMAIN_REDIRECT, false);
        }

        return in_array($domain, $allowedDomains, true);
    }
}
