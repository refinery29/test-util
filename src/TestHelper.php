<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util;

use Faker\Factory;
use Zend\File;

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
            yield $key => [
                $value,
            ];
        }
    }

    /**
     * @param DataProvider\DataProviderInterface[] ...$dataProviders
     *
     * @return \Generator
     */
    final protected function provideDataFrom(DataProvider\DataProviderInterface ...$dataProviders)
    {
        $values = \array_reduce(
            $dataProviders,
            function (array $carry, DataProvider\DataProviderInterface $dataProvider) {
                return \array_merge(
                    $carry,
                    $dataProvider->values()
                );
            },
            []
        );

        return $this->provideData($values);
    }

    /**
     * @param DataProvider\DataProviderInterface[] ...$dataProviders
     *
     * @return array
     */
    final protected function provideCombinedDataFrom(DataProvider\DataProviderInterface ...$dataProviders)
    {
        /**
         * @link https://stackoverflow.com/a/15973172
         */
        $values = [[]];

        foreach ($dataProviders as $key => $provider) {
            $append = [];

            foreach ($values as $product) {
                foreach ($provider->values() as $item) {
                    $product[$key] = $item;
                    $append[] = $product;
                }
            }

            $values = $append;
        }

        return $values;
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
        $this->assertTrue(\class_exists($parentName) || \interface_exists($parentName), \sprintf(
            'Failed to assert that class or interface "%s" exists',
            $parentName
        ));

        $this->assertTrue(\class_exists($childName) || \interface_exists($childName), \sprintf(
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

    /**
     * @param string   $path
     * @param string[] $excludeDirectories
     *
     * @throws \InvalidArgumentException
     */
    final protected function assertClassesAreAbstractOrFinal($path, array $excludeDirectories = [])
    {
        $this->assertClassesSatisfy(
            function (\ReflectionClass $reflection) {
                if ($reflection->isAbstract() || $reflection->isInterface() || $reflection->isTrait()) {
                    return true;
                }

                return $reflection->isFinal();
            },
            $path,
            $excludeDirectories,
            'Failed to assert that classes are abstract or final.'
        );
    }

    /**
     * @param callable $specification
     * @param string   $path
     * @param array    $excludeDirectories
     * @param string   $message
     */
    public function assertClassesSatisfy(callable $specification, $path, array $excludeDirectories = [], $message = null)
    {
        if (!\is_string($path)) {
            throw new \InvalidArgumentException(\sprintf(
                'Path needs to be specified as a string, got "%s".',
                \is_object($path) ? \get_class($path) : \gettype($path)
            ));
        }

        if (!\is_dir($path)) {
            throw new \InvalidArgumentException(\sprintf(
                'Path needs to be specified as an existing directory, got "%s".',
                $path
            ));
        }

        $path = \realpath($path);

        \array_walk($excludeDirectories, function ($excludeDirectory) use ($path) {
            if (!\is_string($excludeDirectory)) {
                throw new \InvalidArgumentException(\sprintf(
                    'Exclude directory needs to be specified as a string, got "%s".',
                    \is_object($excludeDirectory) ? \get_class($excludeDirectory) : \gettype($excludeDirectory)
                ));
            }

            if (!\is_dir($path . DIRECTORY_SEPARATOR . $excludeDirectory)) {
                throw new \InvalidArgumentException(\sprintf(
                    'Exclude directory needs to point to an existing directory within "%s", got "%s".',
                    $path,
                    $excludeDirectory
                ));
            }
        });

        $classFileLocator = new File\ClassFileLocator($path);

        $classFiles = \iterator_to_array(
            $classFileLocator,
            false
        );

        $excludePaths = \array_map(function ($excludeDirectory) use ($path) {
            return \realpath($path . DIRECTORY_SEPARATOR . $excludeDirectory) . DIRECTORY_SEPARATOR;
        }, $excludeDirectories);

        $classNames = \array_reduce(
            $classFiles,
            function (array $classNames, File\PhpClassFile $file) use ($excludePaths) {
                $realPath = $file->getRealPath();
                foreach ($excludePaths as $excludePath) {
                    if (\strpos($realPath, $excludePath) === 0) {
                        return $classNames;
                    }
                }

                return \array_merge(
                    $classNames,
                    $file->getClasses()
                );
            },
            []
        );

        $this->assertGreaterThan(0, \count($classNames), \sprintf(
            'Could not find any relevant PHP files in path "%s"%s.',
            $path,
            \count($excludeDirectories) === 0 ? '' : \sprintf(
                ' excluding "%s"',
                \implode('", "', $excludeDirectories)
            )
        ));

        $classNamesNotSatisfyingSpecification = \array_filter($classNames, function ($className) use ($specification) {
            $reflection = new \ReflectionClass($className);

            $isSatisfied = \call_user_func(
                $specification,
                $reflection
            );

            return false === $isSatisfied;
        });

        $message = $message ?: 'Failed to assert that classes satisfy the specification.';

        $this->assertEmpty(
            $classNamesNotSatisfyingSpecification,
            $message . PHP_EOL . ' - ' . \implode(PHP_EOL . ' - ', $classNamesNotSatisfyingSpecification
        ));
    }
}
