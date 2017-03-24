<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assertion;
use Refinery29\Test\Util\DataProvider\InvalidJsonString;

final class InvalidJsonStringTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidJsonString::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidJsonString::data()
     *
     * @param mixed $value
     */
    public function testIsNotJsonString($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assertion::string($value);
        Assertion::isJsonString($value);
    }
}
