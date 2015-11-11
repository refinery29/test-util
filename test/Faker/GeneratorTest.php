<?php

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
