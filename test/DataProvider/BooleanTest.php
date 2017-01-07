<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\Boolean;

final class BooleanTest extends AbstractTestCase
{
    protected function className()
    {
        return Boolean::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\Boolean::data()
     *
     * @param bool $value
     */
    public function testIsABoolean($value)
    {
        $this->assertTrue(\is_bool($value));
    }
}
