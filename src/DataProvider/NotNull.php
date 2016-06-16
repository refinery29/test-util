<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

/**
 * @internal
 */
trait NotNull
{
    /**
     * @param array $values
     *
     * @return array
     */
    public function notNull(array $values)
    {
        return array_filter($values, function ($value) {
            return $value !== null;
        });
    }
}
