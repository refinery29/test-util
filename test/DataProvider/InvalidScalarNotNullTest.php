<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidScalarNotNull;

class InvalidScalarNotNullTest extends AbstractNotNullTestCase
{
    protected function className()
    {
        return InvalidScalarNotNull::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidScalarNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotAScalar($value)
    {
        $this->assertFalse(is_scalar($value));
    }
}
