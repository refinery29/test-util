<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\BlankString;
use Refinery29\Test\Util\DataProvider\DataProviderInterface;

class BlankStringTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsDataProviderInterface()
    {
        $dataProvider = new BlankString();

        $this->assertInstanceOf(DataProviderInterface::class, $dataProvider);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\BlankString::data()
     *
     * @param mixed $value
     */
    public function testIsBlankString($value)
    {
        $this->assertInternalType('string', $value);
        $this->assertSame('', trim($value));
    }
}
