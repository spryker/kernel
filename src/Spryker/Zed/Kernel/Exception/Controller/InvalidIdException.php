<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Kernel\Exception\Controller;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidIdException extends InvalidArgumentException implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

    /**
     * @return array<string, mixed>
     */
    public function getHeaders(): array
    {
        return [];
    }
}
