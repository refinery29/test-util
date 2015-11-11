<?php

namespace Refinery29\Test\Util\Test\Faker;

use Faker\Generator as BaseGenerator;
use Refinery29\Test\Util\Faker\Generator;
use ReflectionClass;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testExtendsBase()
    {
        $reflectionClass = new ReflectionClass(Generator::class);

        $this->assertTrue($reflectionClass->isSubclassOf(BaseGenerator::class));
    }
}
