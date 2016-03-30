<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

use Traversable;

interface DataProviderInterface
{
    /**
     * This method should return an array or a Traversable, iterating over which should return an array of arguments to
     * pass to a test method that makes use of the concrete data provider.
     *
     * @return array|Traversable
     */
    public function data();
}
