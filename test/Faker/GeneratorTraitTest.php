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

    public function testCanGetFakerStatically()
    {
        $faker = self::getFaker();

        $this->assertInstanceOf('Faker\Generator', $faker);
    }

    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $locale
     */
    public function testGetFakerRejectsInvalidLocale($locale)
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Locale should be a string'
        );

        $this->getFaker($locale);
    }

    public function testGetFakerReturnsFakerWithDefaultLocale()
    {
        $faker = $this->getFaker('en_US');

        $this->assertInstanceOf('Faker\Generator', $faker);
        $this->assertSame($faker, $this->getFaker());
    }

    public function testGetFakerReturnsDifferentFakerForDifferentLocale()
    {
        $faker = $this->getFaker('en_US');

        $this->assertInstanceOf('Faker\Generator', $faker);
        $this->assertNotSame($faker, $this->getFaker('de_DE'));
    }

    /**
     * @dataProvider providerLocale
     *
     * @param string $locale
     */
    public function testGetFakerReturnsTheSameInstanceForALocale($locale)
    {
        $faker = $this->getFaker($locale);

        $this->assertInstanceOf('Faker\Generator', $faker);
        $this->assertSame($faker, $this->getFaker($locale));
    }

    /**
     * @return \Generator
     */
    public function providerLocale()
    {
        $values = [
            'de_DE',
            'en_US',
            'en_UK',
            'fr_FR',
        ];

        foreach ($values as $value) {
            yield [
                $value,
            ];
        }
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
