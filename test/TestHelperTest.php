<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test;

use Faker\Generator;
use Refinery29\Test\Util\Faker\Provider;
use Refinery29\Test\Util\TestHelper;

final class TestHelperTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

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
        return $this->provideData([
            'de_DE',
            'en_US',
            'en_UK',
            'fr_FR',
        ]);
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

        return $this->provideData(array_map(function (\ReflectionMethod $method) {
            return $method->getName();
        }, $reflection->getMethods()));
    }

    public function testProvideDataYieldsValues()
    {
        $faker = $this->getFaker();

        $values = array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $generator = $this->provideData($values);

        $this->assertGeneratorYieldsValues($values, $generator);
    }

    public function testProvideDataFromYieldsValuesFromDataProviderWithArrayOfValues()
    {
        $faker = $this->getFaker();

        $values = array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $dataProvider = new DataProviderFake($values);

        $generator = $this->provideDataFrom($dataProvider);

        $this->assertGeneratorYieldsValues($values, $generator);
    }

    public function testProvideDataFromYieldsValuesFromDataProviderWithTraversableYieldingValues()
    {
        $faker = $this->getFaker();

        $values = array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $dataProvider = new DataProviderFake($this->traversableFrom($values));

        $generator = $this->provideDataFrom($dataProvider);

        $this->assertGeneratorYieldsValues($values, $generator);
    }

    public function testProvideDataFromYieldsValuesFromMultipleDataProviders()
    {
        $faker = $this->getFaker();

        $valuesOne = array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $valuesTwo = array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $generator = $this->provideDataFrom(
            new DataProviderFake($this->traversableFrom($valuesOne)),
            new DataProviderFake($this->traversableFrom($valuesTwo))
        );

        $values = array_merge(
            $valuesOne,
            $valuesTwo
        );

        $this->assertGeneratorYieldsValues($values, $generator);
    }

    public function testAssertFinal()
    {
        $this->assertFinal(Asset\Foo::class);
    }

    public function testAssertImplements()
    {
        $this->assertImplements(\Countable::class, Asset\Foo::class);
    }

    public function testAssertExtends()
    {
        $this->assertExtends(Asset\Bar::class, Asset\Foo::class);
    }

    /**
     * @param $generator
     * @param $values
     */
    private function assertGeneratorYieldsValues($values, $generator)
    {
        $this->assertInstanceOf(\Traversable::class, $generator);

        $expected = array_map(function ($value, $key) {
            return [
                $key => $value,
            ];
        }, array_values($values), array_keys($values));

        $this->assertSame($expected, iterator_to_array($generator));
    }

    /**
     * @param array $values
     *
     * @return \Generator
     */
    private function traversableFrom(array $values)
    {
        foreach ($values as $key => $value) {
            yield $key => $value;
        }
    }
}
