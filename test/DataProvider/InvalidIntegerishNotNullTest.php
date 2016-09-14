<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assertion;
use Refinery29\Test\Util\DataProvider\InvalidIntegerishNotNull;

class InvalidIntegerishNotNullTest extends AbstractDataProviderTestCase
{
    use NotNull;

    public function className()
    {
        return InvalidIntegerishNotNull::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidIntegerishNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotIntegerish($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assertion::integerish($value);
    }
}
