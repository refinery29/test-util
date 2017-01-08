<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util;

use Symfony\Component\Finder;

/**
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/v2.0.0/tests/ProjectCodeTest.php
 */
abstract class AbstractTestClassTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string   $directory
     * @param string   $psr4Prefix
     * @param string[] $excludeDirectories
     *
     * @throws \InvalidArgumentException
     */
    final protected function createTest($directory, $psr4Prefix, array $excludeDirectories = [])
    {
        if (!\is_string($directory) || !\is_dir($directory)) {
            throw new \InvalidArgumentException(\sprintf(
                'Directory needs to point to an existing directory, got "%s".',
                \is_object($directory) ? \get_class($directory) : \gettype($directory)
            ));
        }

        if (!\is_string($psr4Prefix)) {
            throw new \InvalidArgumentException(\sprintf(
                'PSR-4 prefix needs to be a string, got "%s".',
                \is_object($directory) ? \get_class($directory) : \gettype($directory)
            ));
        }

        \array_walk($excludeDirectories, function ($excludeDirectory) use ($directory) {
            if (!\is_string($excludeDirectory) || !\is_dir($directory . DIRECTORY_SEPARATOR . $excludeDirectory)) {
                throw new \InvalidArgumentException(\sprintf(
                    'Exclude directory needs to point to an existing directory, got "%s".',
                    \is_object($excludeDirectory) ? \get_class($excludeDirectory) : \gettype($excludeDirectory)
                ));
            }
        });

        $finder = Finder\Finder::create()
            ->files()
            ->name('*.php')
            ->in($directory)
            ->exclude($excludeDirectories);

        $exclusion = '';
        if (\count($excludeDirectories)) {
            $exclusion = \sprintf(
                ' excluding "%s"',
                \implode('", "', $excludeDirectories)
            );
        }

        $files = \iterator_to_array(
            $finder,
            false
        );

        $this->assertGreaterThan(0, \count($files), \sprintf(
            'Could not find any PHP files in directory "%s"%s.',
            $directory,
            $exclusion
        ));

        $psr4Prefix = \rtrim($psr4Prefix, '\\');

        \array_walk($files, function (Finder\SplFileInfo $file) use ($psr4Prefix) {
            $className = \sprintf(
                '%s\%s%s%s',
                $psr4Prefix,
                \strtr($file->getRelativePath(), DIRECTORY_SEPARATOR, '\\'),
                $file->getRelativePath() ? '\\' : '',
                $file->getBasename('.' . $file->getExtension())
            );

            $reflection = new \ReflectionClass($className);

            if ($reflection->isTrait() || $reflection->isInterface()) {
                return;
            }

            $this->assertTrue($reflection->isAbstract() || $reflection->isFinal(), \sprintf(
                'Failed to assert that the test class "%s" is abstract or final.',
                $className
            ));
        });
    }
}
