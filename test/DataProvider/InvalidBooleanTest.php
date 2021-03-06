<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\InvalidBoolean;

final class InvalidBooleanTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidBoolean::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $value
     */
    public function testIsNotBoolean($value)
    {
        $this->assertFalse(\is_bool($value));
    }
}
