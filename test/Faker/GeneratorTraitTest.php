<?php

namespace Refinery29\Test\Unit;

use Faker\Generator;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class GeneratorTraitTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testCanGetFaker()
    {
        $faker = $this->getFaker();

        $this->assertInstanceOf(Generator::class, $faker);
    }

    public function testGetFakerReturnsTheSameInstance()
    {
        $faker = $this->getFaker();

        $this->assertSame($faker, $this->getFaker());
    }
}
