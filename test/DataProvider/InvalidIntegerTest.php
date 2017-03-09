<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidInteger;

final class InvalidIntegerTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidInteger::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidInteger::data()
     *
     * @param mixed $value
     */
    public function testIsNotInteger($value)
    {
        $this->assertFalse(\is_int($value));
    }
}
