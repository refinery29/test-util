<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assertion;
use Refinery29\Test\Util\DataProvider\InvalidIsoDateNotNull;

class InvalidIsoDateNotNullTest extends AbstractDataProviderTestCase
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
    public function testIsNotAnIsoDate($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assertion::string($value);
        Assertion::date($value, DATE_ISO8601);
    }
}
