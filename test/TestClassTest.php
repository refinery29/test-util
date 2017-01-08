<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test;

use Refinery29\Test\Util\AbstractTestClassTestCase;

final class TestClassTest extends AbstractTestClassTestCase
{
    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $path
     */
    public function testCreateTestRejectsInvalidPath($path)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Path needs to be specified as a string, got "%s".',
            \is_object($path) ? \get_class($path) : \gettype($path)
        ));

        $this->createTest($path);
    }

    public function testCreateTestRejectsNonExistentPath()
    {
        $path = __DIR__ . '/NonExistent';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Path needs to be specified as an existing directory, got "%s".',
            $path
        ));

        $this->createTest($path);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $excludeDirectory
     */
    public function testCreateTestRejectsInvalidExcludeDirectory($excludeDirectory)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Exclude directory needs to be specified as a string, got "%s".',
            \is_object($excludeDirectory) ? \get_class($excludeDirectory) : \gettype($excludeDirectory)
        ));

        $this->createTest(__DIR__, [
            $excludeDirectory,
        ]);
    }

    public function testCreateTestRejectsNonExistentExcludeDirectory()
    {
        $path = __DIR__;
        $excludeDirectory = 'NonExistent';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Exclude directory needs to point to an existing directory within "%s", got "%s".',
            $path,
            $excludeDirectory
        ));

        $this->createTest(
            $path, [
            $excludeDirectory,
        ]);
    }

    public function testCreateTestFailsIfNoRelevantPhpFilesHaveBeenFound()
    {
        $path = __DIR__ . '/Asset/Empty';

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage(\sprintf(
            'Could not find any relevant PHP files in path "%s".',
            $path
        ));

        $this->createTest($path);
    }

    public function testCreateTestWithExclusionsFailsIfNoRelevantPhpFilesHaveBeenFound()
    {
        $path = __DIR__ . '/Asset/NotEmpty';
        $excludeDirectories = [
            'Bar',
            'Foo',
        ];

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage(\sprintf(
            'Could not find any relevant PHP files in path "%s" excluding "%s".',
            $path,
            \implode('", "', $excludeDirectories)
        ));

        $this->createTest(
            $path,
            $excludeDirectories
        );
    }

    public function testCreateTestIgnoresInterfacesAndTraits()
    {
        $this->createTest(__DIR__ . '/Asset/NotClasses');
    }

    public function testTestClassesAreAbstractOrFinal()
    {
        $this->createTest(__DIR__, [
            'Asset',
        ]);
    }
}
