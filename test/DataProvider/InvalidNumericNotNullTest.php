<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidNumericNotNull;

final class InvalidNumericNotNullTest extends AbstractNotNullTestCase
{
    public function className()
    {
        return InvalidNumericNotNull::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidNumericNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotNumeric($value)
    {
        $this->assertFalse(\is_numeric($value));
    }
}
