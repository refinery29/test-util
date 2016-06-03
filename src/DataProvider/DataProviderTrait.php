<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

trait DataProviderTrait
{
    /**
     * @param array $values
     *
     * @return \Generator
     */
    public function provideData(array $values)
    {
        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
    }
}
