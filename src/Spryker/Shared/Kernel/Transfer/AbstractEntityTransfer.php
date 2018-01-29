<?php
/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\Kernel\Transfer;

class AbstractEntityTransfer extends AbstractTransfer implements EntityTransferInterface
{
    /**
     * @var null|string
     */
    protected $_entityNamespace = null;

    /**
     * Returns FQCN of propel entity it's mapped
     *
     * @return string
     */
    public function _getEntityNamespace()
    {
        return $this->_entityNamespace;
    }
}
