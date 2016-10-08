<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert;
use Refinery29\Test\Util\DataProvider\InvalidIsoDate;

final class InvalidIsoDateTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidIsoDate::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidIsoDate::data()
     *
     * @param mixed $value
     */
    public function testIsNotAnIsoDate($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert\that($value)->string()->date(DATE_ATOM);
    }
}
