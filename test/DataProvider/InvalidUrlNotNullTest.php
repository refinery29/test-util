<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assertion;
use Refinery29\Test\Util\DataProvider\InvalidUrlNotNull;

class InvalidUrlNotNullTest extends AbstractDataProviderTestCase
{
    use NotNull;

    protected function className()
    {
        return InvalidUrlNotNull::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidUrlNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotAUrl($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assertion::nullOrUrl($value);
    }
}
