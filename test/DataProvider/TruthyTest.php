<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\Truthy;

final class TruthyTest extends AbstractTestCase
{
    protected function className()
    {
        return Truthy::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\Truthy::data()
     *
     * @param mixed $value
     */
    public function testIsTruthy($value)
    {
        $this->assertTrue((bool) $value);
    }
}
