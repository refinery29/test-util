<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use Generator;

interface DataProviderInterface
{
    /**
     * @return array|Generator
     */
    public function data();
}
