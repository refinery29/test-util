<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidUrlNotNull extends InvalidUrl
{
    use NotNull;

    protected function values()
    {
        return $this->notNull(parent::values());
    }
}
