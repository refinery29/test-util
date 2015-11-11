<?php

namespace Refinery29\Test\Util\Test\Faker;

use Faker\Generator;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use Refinery29\Test\Util\Faker\Provider\Color;
use ReflectionClass;

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

    /**
     * @dataProvider providerHasColorProviderAttached
     *
     * @param string $formatter
     */
    public function testHasColorProviderAttached($formatter)
    {
        $faker = $this->getFaker();

        $reflection = new ReflectionClass($faker);

        $method = $reflection->getMethod('getFormatter');
        $method->setAccessible(true);

        $callable = $method->invoke($faker, $formatter);

        $this->assertInternalType('array', $callable);
        $this->assertInstanceOf(Color::class, $callable[0]);
        $this->assertSame($formatter, $callable[1]);
    }

    /**
     * @return \Generator
     */
    public function providerHasColorProviderAttached()
    {
        $reflectionClass = new ReflectionClass(Color::class);

        foreach ($reflectionClass->getMethods() as $method) {
            yield [
                $method->getName(),
            ];
        }
    }
}
