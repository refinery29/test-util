<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util;

use Zend\File;

/**
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/v2.0.0/tests/ProjectCodeTest.php
 */
abstract class AbstractTestClassTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string   $path
     * @param string[] $excludeDirectories
     *
     * @throws \InvalidArgumentException
     */
    final protected function createTest($path, array $excludeDirectories = [])
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

        $files = iterator_to_array(
            $classFileLocator,
            false
        );

        $excludePaths = \array_map(function ($excludeDirectory) use ($path) {
            return \realpath($path . DIRECTORY_SEPARATOR . $excludeDirectory);
        }, $excludeDirectories);

        $classNames = \array_reduce(
            $files,
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

        $exclusion = '';
        if (\count($excludeDirectories)) {
            $exclusion = \sprintf(
                ' excluding "%s"',
                \implode('", "', $excludeDirectories)
            );
        }

        $this->assertGreaterThan(0, \count($classNames), \sprintf(
            'Could not find any relevant PHP files in path "%s"%s.',
            $path,
            $exclusion
        ));

        $neitherAbstractNorFinal = \array_filter($classNames, function ($className) {
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

        $this->assertEmpty($neitherAbstractNorFinal, \sprintf(
            'Failed to assert that "%s" are abstract or final.',
            \implode('", "', $neitherAbstractNorFinal)
        ));
    }
}
