<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert;
use Refinery29\Test\Util\DataProvider\InvalidIsoDateNotNull;

final class InvalidIsoDateNotNullTest extends AbstractNotNullTestCase
{
    protected function className()
    {
        return InvalidIsoDateNotNull::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidIsoDateNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotIsoDate($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert\that($value)->string()->date(DATE_ATOM);
    }
}
