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
    public function testCreateTestRejectsNonExistentDirectory()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->createTest(
            __DIR__ . '/NonExistent',
            'Refinery29\Test\Util\Test'
        );
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $psr4Prefix
     */
    public function testCreateTestRejectsInvalidPsr4Prefix($psr4Prefix)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->createTest(
            __DIR__,
            $psr4Prefix
        );
    }

    public function testCreateTestRejectsNonExistentExcludedDirectory()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->createTest(
            __DIR__,
            'Refinery29\Test\Util\Test',
            [
                'NonExistent',
            ]
        );
    }

    public function testCreateTestFailsIfNoPhpFilesHaveBeenFound()
    {
        $directory = __DIR__ . '/Asset/Empty';

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage(\sprintf(
            'Could not find any PHP files in directory "%s".',
            $directory
        ));

        $this->createTest(
            $directory,
            'Refinery29\Test\Util\Test\Asset\Empty'
        );
    }

    public function testCreateTestWithExclusionsFailsIfNoPhpFilesHaveBeenFound()
    {
        $directory = __DIR__ . '/Asset/HalfEmpty';
        $exclusions = [
            'Bar',
            'Foo',
        ];

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage(\sprintf(
            'Could not find any PHP files in directory "%s" excluding "%s".',
            $directory,
            \implode('", "', $exclusions)
        ));

        $this->createTest(
            $directory,
            'Refinery29\Test\Util\Test\Asset\HalfEmpty',
            $exclusions
        );
    }

    public function testCreateTestIgnoresInterfacesAndTraits()
    {
        $this->createTest(
            __DIR__ . '/Asset/NotClasses',
            'Refinery29\Test\Util\Test\Asset\NotClasses'
        );
    }

    public function testTestClassesAreAbstractOrFinal()
    {
        $this->createTest(
            __DIR__,
            'Refinery29\Test\Util\Test',
            [
                'Asset',
            ]
        );
    }
}
