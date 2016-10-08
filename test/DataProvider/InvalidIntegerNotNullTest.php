<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidIntegerNotNull;

final class InvalidIntegerNotNullTest extends AbstractNotNullTestCase
{
    public function className()
    {
        return InvalidIntegerNotNull::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidIntegerNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotAnInteger($value)
    {
        $this->assertFalse(is_int($value));
    }
}
