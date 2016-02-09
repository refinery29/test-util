<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\Faker;

use Refinery29\Test\Util\Faker\GeneratorTrait;
use ReflectionClass;

class GeneratorTraitTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testCanGetFaker()
    {
        $faker = $this->getFaker();

        $this->assertInstanceOf('Faker\Generator', $faker);
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
        $this->assertInstanceOf('Refinery29\Test\Util\Faker\Provider\Color', $callable[0]);
        $this->assertSame($formatter, $callable[1]);
    }

    /**
     * @return \Generator
     */
    public function providerHasColorProviderAttached()
    {
        $reflectionClass = new ReflectionClass('Refinery29\Test\Util\Faker\Provider\Color');

        $data = [];

        foreach ($reflectionClass->getMethods() as $method) {
            $data[] = [
                $method->getName(),
            ];
        }

        return $data;
    }
}
