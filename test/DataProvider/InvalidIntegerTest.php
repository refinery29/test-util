<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assertion;
use InvalidArgumentException;
use Refinery29\Test\Util\DataProvider\DataProviderInterface;
use Refinery29\Test\Util\DataProvider\InvalidInteger;

class InvalidIntegerTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsDataProviderInterface()
    {
        $dataProvider = new InvalidInteger();

        $this->assertInstanceOf(DataProviderInterface::class, $dataProvider);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidInteger::data()
     *
     * @param mixed $value
     */
    public function testIsNotAnInteger($value)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        Assertion::integer($value);
    }
}
