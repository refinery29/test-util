<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert;
use Refinery29\Test\Util\DataProvider\InvalidIntegerish;

final class InvalidIntegerishTest extends AbstractTestCase
{
    protected function className()
    {
        return InvalidIntegerish::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidIntegerish::data()
     *
     * @param mixed $value
     */
    public function testIsNotIntegerish($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert\that($value)->integerish();
    }
}
