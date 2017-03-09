<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Assert\Assert;
use Refinery29\Test\Util\DataProvider\InvalidUrlNotNull;

final class InvalidUrlNotNullTest extends AbstractNotNullTestCase
{
    protected function className()
    {
        return InvalidUrlNotNull::class;
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidUrlNotNull::data()
     *
     * @param mixed $value
     */
    public function testIsNotUrl($value)
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::that($value)->url();
    }
}
