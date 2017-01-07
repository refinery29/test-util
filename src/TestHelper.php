<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util;

use Faker\Factory;

trait TestHelper
{
    /**
     * @param string $locale
     *
     * @return Faker\Generator
     */
    final protected function getFaker($locale = 'en_US')
    {
        static $fakers = [];

        if (!\is_string($locale)) {
            throw new \InvalidArgumentException('Locale should be a string');
        }

        if (!\array_key_exists($locale, $fakers)) {
            $faker = Factory::create($locale);
            $faker->addProvider(new Faker\Provider\Color());
            $faker->seed(9000);

            $fakers[$locale] = $faker;
        }

        return $fakers[$locale];
    }

    /**
     * @param array $values
     *
     * @return \Generator
     */
    final protected function provideData(array $values)
    {
        foreach ($values as $key => $value) {
            yield [
                $key => $value,
            ];
        }
    }

    /**
     * @param DataProvider\DataProviderInterface[] ...$dataProviders
     *
     * @return \Generator
     */
    final protected function provideDataFrom(...$dataProviders)
    {
        /*
         * This works around @link https://github.com/facebook/hhvm/issues/6954, otherwise we would just type-hint in
         * the method signature above.
         */
        $dataProviders = \array_map(function (DataProvider\DataProviderInterface $dataProvider) {
            return $dataProvider;
        }, $dataProviders);

        $values = \array_reduce(
            $dataProviders,
            function (array $carry, DataProvider\DataProviderInterface $dataProvider) {
                $values = $dataProvider->values();

                if ($values instanceof \Traversable) {
                    $values = \iterator_to_array($values);
                }

                return \array_merge(
                    $carry,
                    $values
                );
            },
            []
        );

        return $this->provideData($values);
    }

    /**
     * @param string $className
     */
    final protected function assertFinal($className)
    {
        $this->assertTrue(\class_exists($className), \sprintf(
            'Failed to assert that class "%s" exists',
            $className
        ));

        $reflection = new \ReflectionClass($className);

        $this->assertTrue($reflection->isFinal(), \sprintf(
            'Failed to assert that "%s" is final',
            $className
        ));
    }

    /**
     * @param string $parentName
     * @param string $childName
     */
    final protected function assertExtends($parentName, $childName)
    {
        $this->assertTrue(\class_exists($parentName) || interface_exists($parentName), \sprintf(
            'Failed to assert that class or interface "%s" exists',
            $parentName
        ));

        $this->assertTrue(\class_exists($childName) || interface_exists($childName), \sprintf(
            'Failed to assert that class or interface "%s" exists',
            $childName
        ));

        $reflection = new \ReflectionClass($childName);

        $this->assertTrue($reflection->isSubclassOf($parentName), \sprintf(
            'Failed to assert that "%s" extends "%s"',
            $childName,
            $parentName
        ));
    }

    /**
     * @param string $interfaceName
     * @param string $className
     */
    final protected function assertImplements($interfaceName, $className)
    {
        $this->assertTrue(\interface_exists($interfaceName), \sprintf(
            'Failed to assert that interface "%s" exists',
            $interfaceName
        ));

        $this->assertTrue(\class_exists($className), \sprintf(
            'Failed to assert that class "%s" exists',
            $className
        ));

        $reflection = new \ReflectionClass($className);

        $this->assertTrue($reflection->implementsInterface($interfaceName), \sprintf(
            'Failed to assert that "%s" implements "%s"',
            $className,
            $interfaceName
        ));
    }
}
