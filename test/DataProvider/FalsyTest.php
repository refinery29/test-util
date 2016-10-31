<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\Falsy;

final class FalsyTest extends AbstractTestCase
{
    protected function className()
    {
        return Falsy::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\Falsy::data()
     *
     * @param mixed $value
     */
    public function testIsFalsy($value)
    {
        $this->assertFalse((bool) $value);
    }
}
