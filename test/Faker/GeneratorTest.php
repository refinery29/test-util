<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\Faker;

use ReflectionClass;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testExtendsBase()
    {
        $reflectionClass = new ReflectionClass('Refinery29\Test\Util\Faker\Generator');

        $this->assertTrue($reflectionClass->isSubclassOf('Faker\Generator'));
    }
}
