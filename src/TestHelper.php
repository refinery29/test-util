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

    /**
     * @param string   $path
     * @param string[] $excludeDirectories
     *
     * @throws \InvalidArgumentException
     */
    final protected function assertClassesAreAbstractOrFinal($path, array $excludeDirectories = [])
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

                return array_merge(
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

        $classNamesNeitherAbstractNorFinal = \array_filter($classNames, function ($className) {
            $reflection = new \ReflectionClass($className);

            if ($reflection->isTrait()
                || $reflection->isInterface()
                || $reflection->isAbstract()
                || $reflection->isFinal()
            ) {
                return false;
            }

            return true;
        });

        $this->assertEmpty($classNamesNeitherAbstractNorFinal, \sprintf(
            'Failed to assert that the following classes are abstract or final: %s',
            PHP_EOL . ' - ' . \implode(PHP_EOL . ' - ', $classNamesNeitherAbstractNorFinal)
        ));
    }
}
