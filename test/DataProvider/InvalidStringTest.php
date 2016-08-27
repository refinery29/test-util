<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidString;

class InvalidStringTest extends AbstractDataProviderTestCase
{
    protected function className()
    {
        return InvalidString::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $value
     */
    public function testIsNotAString($value)
    {
        $this->assertFalse(is_string($value));
    }
}
