<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidBoolean;

class InvalidBooleanTest extends AbstractDataProviderTestCase
{
    protected function className()
    {
        return InvalidBoolean::class;
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $value
     */
    public function testIsNotABoolean($value)
    {
        $this->assertFalse(is_bool($value));
    }
}
