<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class Boolean extends AbstractDataProvider
{
    public function values()
    {
        return [
            'boolean-false' => false,
            'boolean-true' => true,
        ];
    }
}
