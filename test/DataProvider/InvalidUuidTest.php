<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assertion;
use Refinery29\Test\Util\DataProvider\DataProviderInterface;
use Refinery29\Test\Util\DataProvider\InvalidUuid;

class InvalidUuidTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsDataProviderInterface()
    {
        $dataProvider = new InvalidUuid();

        $this->assertInstanceOf(DataProviderInterface::class, $dataProvider);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidUuid::data()
     *
     * @param mixed $value
     */
    public function testIsNotAUuid($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assertion::string($value);
        Assertion::uuid($value);
    }
}
