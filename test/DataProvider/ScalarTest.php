<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\Scalar;

class ScalarTest extends AbstractDataProviderTestCase
{
    protected function className()
    {
        return Scalar::class;
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\Scalar::data()
     *
     * @param mixed $value
     */
    public function testIsAScalar($value)
    {
        $this->assertTrue(is_scalar($value));
    }
}
