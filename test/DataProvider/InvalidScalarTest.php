<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidScalar;

final class InvalidScalarTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidScalar::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidScalar::data()
     *
     * @param mixed $value
     */
    public function testIsNotScalar($value)
    {
        $this->assertFalse(\is_scalar($value));
    }
}
