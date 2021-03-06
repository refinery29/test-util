<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidFloat;

final class InvalidFloatTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidFloat::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidFloat::data()
     *
     * @param mixed $value
     */
    public function testIsNotFloat($value)
    {
        $this->assertFalse(\is_float($value));
    }
}
