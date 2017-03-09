<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\Faker;

use Faker\Generator as OriginalGenerator;
use PHPUnit\Framework;
use Refinery29\Test\Util\Faker\Generator;

final class GeneratorTest extends Framework\TestCase
{
    public function testExtendsBase()
    {
        $reflection = new \ReflectionClass(Generator::class);

        $this->assertTrue($reflection->isSubclassOf(OriginalGenerator::class));
    }
}
