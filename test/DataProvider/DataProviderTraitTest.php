<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\DataProviderTrait;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class DataProviderTraitTest extends \PHPUnit_Framework_TestCase
{
    use DataProviderTrait;
    use GeneratorTrait;

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
