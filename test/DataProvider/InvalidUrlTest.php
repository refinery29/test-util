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
use Refinery29\Test\Util\DataProvider\InvalidUrl;

class InvalidUrlTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsDataProviderInterface()
    {
        $dataProvider = new InvalidUrl();

        $this->assertInstanceOf(DataProviderInterface::class, $dataProvider);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidUrl::data()
     *
     * @param mixed $value
     */
    public function testIsNotAUrl($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assertion::url($value);
    }
}
