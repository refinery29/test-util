<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\Faker;

use Faker\Generator;
use Refinery29\Test\Util\Faker\GeneratorTrait;
use Refinery29\Test\Util\Faker\Provider;

class GeneratorTraitTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testCanGetFaker()
    {
        $faker = $this->getFaker();

        $this->assertInstanceOf(Generator::class, $faker);
    }

    public function testCanGetFakerStatically()
    {
        $faker = self::getFaker();

        $this->assertInstanceOf(Generator::class, $faker);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $locale
     */
    public function testGetFakerRejectsInvalidLocale($locale)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Locale should be a string');

        $this->getFaker($locale);
    }

    public function testGetFakerReturnsFakerWithDefaultLocale()
    {
        $faker = $this->getFaker('en_US');

        $this->assertInstanceOf(Generator::class, $faker);
        $this->assertSame($faker, $this->getFaker());
    }

    public function testGetFakerReturnsDifferentFakerForDifferentLocale()
    {
        $faker = $this->getFaker('en_US');

        $this->assertInstanceOf(Generator::class, $faker);
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

        $this->assertInstanceOf(Generator::class, $faker);
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

        $reflection = new \ReflectionClass($faker);

        $method = $reflection->getMethod('getFormatter');
        $method->setAccessible(true);

        $callable = $method->invoke($faker, $formatter);

        $this->assertInternalType('array', $callable);
        $this->assertInstanceOf(Provider\Color::class, $callable[0]);
        $this->assertSame($formatter, $callable[1]);
    }

    /**
     * @return \Generator
     */
    public function providerHasColorProviderAttached()
    {
        $reflection = new \ReflectionClass(Provider\Color::class);

        $data = [];

        foreach ($reflection->getMethods() as $method) {
            $data[] = [
                $method->getName(),
            ];
        }

        return $data;
    }
}
