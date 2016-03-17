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
use Refinery29\Test\Util\DataProvider\InvalidBoolean;

class InvalidBooleanTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsDataProviderInterface()
    {
        $dataProvider = new InvalidBoolean();

        $this->assertInstanceOf(DataProviderInterface::class, $dataProvider);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidBoolean::data()
     *
     * @param mixed $value
     */
    public function testIsNotABoolean($value)
    {
        $this->setExpectedException(InvalidArgumentException::class);

        Assertion::boolean($value);
    }
}
