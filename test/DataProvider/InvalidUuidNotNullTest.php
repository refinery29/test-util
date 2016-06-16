<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assertion;
use Refinery29\Test\Util\DataProvider\InvalidUuidNotNull;

class InvalidUuidNotNullTest extends AbstractDataProviderTestCase
{
    use NotNull;

    protected function className()
    {
        return InvalidUuidNotNull::class;
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidUuidNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotAUuid($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assertion::nullOrString($value);
        Assertion::nullOrUuid($value);
    }
}
