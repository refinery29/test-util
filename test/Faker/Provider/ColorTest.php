<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\Faker\Provider;

use PHPUnit\Framework;
use Refinery29\Test\Util\Faker\Provider\Color;

final class ColorTest extends Framework\TestCase
{
    /**
     * @link https://github.com/fzaninotto/Faker/blob/v1.5.0/test/Faker/Provider/ColorTest.php#L10-L13
     */
    public function testHexColorWithAlpha()
    {
        $this->assertRegExp('/^#[a-f0-9]{8}$/i', Color::hexColorWithAlpha());
    }

    public function testHexColorShort()
    {
        $this->assertRegExp('/^#[a-f0-9]{3}$/i', Color::hexColorShort());
    }
}
