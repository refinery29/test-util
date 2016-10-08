<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidNumeric;

final class InvalidNumericTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidNumeric::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidNumeric::data()
     *
     * @param mixed $value
     */
    public function testIsNotNumeric($value)
    {
        $this->assertFalse(is_numeric($value));
    }
}
