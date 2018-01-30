<?php
/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\Transfer;

interface EntityTransferInterface extends TransferInterface
{
    /**
     * Returns FQCN of propel entity it's mapped
     *
     * @return string
     */
    public function _getEntityNamespace();
}