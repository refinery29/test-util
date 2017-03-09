<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test;

use Faker\Generator;
use PHPUnit\Framework;
use Refinery29\Test\Util\Faker\Provider;
use Refinery29\Test\Util\TestHelper;

/**
 * @param \ReflectionClass $reflection
 *
 * @return bool
 */
function satisfy(\ReflectionClass $reflection)
{
    $name = $reflection->getName();

    return $name === Asset\Satisfy\Foo::class;
}

final class TestHelperTest extends Framework\TestCase
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

        return $this->provideData(\array_map(function (\ReflectionMethod $method) {
            return $method->getName();
        }, $reflection->getMethods()));
    }

    public function testProvideDataYieldsValues()
    {
        $faker = $this->getFaker();

        $values = \array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $generator = $this->provideData($values);

        $this->assertGeneratorYieldsValues($values, $generator);
    }

    public function testProvideDataFromYieldsValuesFromDataProvider()
    {
        $faker = $this->getFaker();

        $values = \array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $generator = $this->provideDataFrom(new DataProviderFake($values));

        $this->assertGeneratorYieldsValues($values, $generator);
    }

    public function testProvideDataFromYieldsValuesFromMultipleDataProviders()
    {
        $faker = $this->getFaker();

        $valuesOne = \array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $valuesTwo = \array_combine(
            $faker->unique()->words(5),
            $faker->unique()->words(5)
        );

        $generator = $this->provideDataFrom(
            new DataProviderFake($valuesOne),
            new DataProviderFake($valuesTwo)
        );

        $values = \array_merge(
            $valuesOne,
            $valuesTwo
        );

        $this->assertGeneratorYieldsValues($values, $generator);
    }

    public function testAssertFinalFailsWhenClassDoesNotExist()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertFinal('foobarbaz');
    }

    public function testAssertFinalFailsWhenClassIsNotFinal()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertFinal(Asset\NonFinalClass::class);
    }

    public function testAssertFinalSucceedsWhenClassIsFinal()
    {
        $this->assertFinal(Asset\FinalClass::class);
    }

    public function testAssertExtendsFailsWhenParentClassDoesNotExist()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertExtends('foobarbaz', Asset\ChildClass::class);
    }

    public function testAssertExtendsFailsWhenParentInterfaceDoesNotExist()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertExtends('foobarbaz', Asset\ChildInterface::class);
    }

    public function testAssertExtendsFailsWhenChildClassDoesNotExist()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertExtends(Asset\ParentClass::class, 'foobarbaz');
    }

    public function testAssertExtendsFailsWhenChildInterfaceDoesNotExist()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertExtends(Asset\ParentInterface::class, 'foobarbaz');
    }

    public function testAssertExtendsFailsWhenChildClassDoesNotExtendParentClass()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertExtends(Asset\ChildClass::class, Asset\ParentClass::class);
    }

    public function testAssertExtendsFailsWhenChildInterfaceDoesNotExtendParentInterface()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertExtends(Asset\ChildInterface::class, Asset\ParentInterface::class);
    }

    public function testAssertExtendsSucceedsWhenChildClassExtendsParentClass()
    {
        $this->assertExtends(Asset\ParentClass::class, Asset\ChildClass::class);
    }

    public function testAssertExtendsSucceedsWhenChildInterfaceExtendsParentInterface()
    {
        $this->assertExtends(Asset\ParentInterface::class, Asset\ChildInterface::class);
    }

    public function testAssertImplementsFailsWhenInterfaceDoesNotExist()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertImplements('foobarbaz', Asset\ImplementingClass::class);
    }

    public function testAssertImplementsFailsWhenClassDoesNotExist()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertImplements(Asset\ImplementedInterface::class, 'foobarbaz');
    }

    public function testAssertImplementFailsWhenClassDoesNotImplementInterface()
    {
        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);

        $this->assertImplements(Asset\ImplementedInterface::class, Asset\NonImplementingClass::class);
    }

    public function testAssertImplementSucceedsWhenClassImplementsInterface()
    {
        $this->assertImplements(Asset\ImplementedInterface::class, Asset\ImplementingClass::class);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $path
     */
    public function testAssertClassesAreAbstractOrFinalRejectsInvalidPath($path)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Path needs to be specified as a string, got "%s".',
            \is_object($path) ? \get_class($path) : \gettype($path)
        ));

        $this->assertClassesAreAbstractOrFinal($path);
    }

    public function testAssertClassesAreAbstractOrFinalRejectsNonExistentPath()
    {
        $path = __DIR__ . '/NonExistent';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Path needs to be specified as an existing directory, got "%s".',
            $path
        ));

        $this->assertClassesAreAbstractOrFinal($path);
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $excludeDirectory
     */
    public function testAssertClassesAreAbstractOrFinalRejectsInvalidExcludeDirectory($excludeDirectory)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Exclude directory needs to be specified as a string, got "%s".',
            \is_object($excludeDirectory) ? \get_class($excludeDirectory) : \gettype($excludeDirectory)
        ));

        $this->assertClassesAreAbstractOrFinal(__DIR__, [
            $excludeDirectory,
        ]);
    }

    public function testAssertClassesAreAbstractOrFinalRejectsNonExistentExcludeDirectory()
    {
        $path = __DIR__;
        $excludeDirectory = 'NonExistent';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Exclude directory needs to point to an existing directory within "%s", got "%s".',
            $path,
            $excludeDirectory
        ));

        $this->assertClassesAreAbstractOrFinal(
            $path, [
            $excludeDirectory,
        ]);
    }

    public function testAssertClassesAreAbstractOrFinalFailsIfNoRelevantPhpFilesHaveBeenFound()
    {
        $path = __DIR__ . '/Asset/Empty';

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage(\sprintf(
            'Could not find any relevant PHP files in path "%s".',
            $path
        ));

        $this->assertClassesAreAbstractOrFinal($path);
    }

    public function testAssertClassesAreAbstractOrFinalWithExclusionsFailsIfNoRelevantPhpFilesHaveBeenFound()
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

        $this->assertClassesAreAbstractOrFinal(
            $path,
            $excludeDirectories
        );
    }

    public function testAssertClassesAreAbstractOrFinalWithExclusionsHonorsDirectoriesOnly()
    {
        $path = __DIR__ . '/Asset/WithExclude';
        $excludeDirectories = [
            'Exclude',
        ];

        $classNamesNeitherAbstractNorFinal = [
            Asset\WithExclude\Exclude::class,
            Asset\WithExclude\ExcludeNot\Bar::class,
        ];

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage(\sprintf(
            'Failed to assert that classes are abstract or final.%s',
            PHP_EOL . ' - ' . \implode(PHP_EOL . ' - ', $classNamesNeitherAbstractNorFinal)
        ));

        $this->assertClassesAreAbstractOrFinal(
            $path,
            $excludeDirectories
        );
    }

    public function testAssertClassesAreAbstractOrFinalIgnoresInterfacesAndTraits()
    {
        $this->assertClassesAreAbstractOrFinal(__DIR__ . '/Asset/NotClasses');
    }

    /**
     * @requires PHP 7.1
     */
    public function testAssertClassesAreAbstractOrFinalIgnoresAnonymousClasses()
    {
        $this->assertClassesAreAbstractOrFinal(__DIR__ . '/Asset/AnonymousClasses');
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $path
     */
    public function testAssertClassesSatisfyRejectsInvalidPath($path)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Path needs to be specified as a string, got "%s".',
            \is_object($path) ? \get_class($path) : \gettype($path)
        ));

        $this->assertClassesSatisfy(
            function () {
                return true;
            },
            $path
        );
    }

    public function testAssertClassesSatisfyRejectsNonExistentPath()
    {
        $path = __DIR__ . '/NonExistent';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Path needs to be specified as an existing directory, got "%s".',
            $path
        ));

        $this->assertClassesSatisfy(
            function () {
                return true;
            },
            $path
        );
    }

    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     *
     * @param mixed $excludeDirectory
     */
    public function testAssertSatisfyRejectsInvalidExcludeDirectory($excludeDirectory)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Exclude directory needs to be specified as a string, got "%s".',
            \is_object($excludeDirectory) ? \get_class($excludeDirectory) : \gettype($excludeDirectory)
        ));

        $this->assertClassesSatisfy(
            function () {
                return true;
            },
            __DIR__,
            [
                $excludeDirectory,
            ]
        );
    }

    public function testAssertClassesSatisfyRejectsNonExistentExcludeDirectory()
    {
        $path = __DIR__;
        $excludeDirectory = 'NonExistent';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(\sprintf(
            'Exclude directory needs to point to an existing directory within "%s", got "%s".',
            $path,
            $excludeDirectory
        ));

        $this->assertClassesSatisfy(
            function () {
                return true;
            },
            $path,
            [
                $excludeDirectory,
            ]
        );
    }

    public function testAssertClassesSatisfyFailsIfNoRelevantPhpFilesHaveBeenFound()
    {
        $path = __DIR__ . '/Asset/Empty';

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage(\sprintf(
            'Could not find any relevant PHP files in path "%s".',
            $path
        ));

        $this->assertClassesSatisfy(
            function () {
                return true;
            },
            $path
        );
    }

    public function testAssertClassesSatisfyWithExclusionsFailsIfNoRelevantPhpFilesHaveBeenFound()
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

        $this->assertClassesSatisfy(
            function () {
                return true;
            },
            $path,
            $excludeDirectories
        );
    }

    public function testAssertClassesSatisfyWithExclusionsHonorsDirectoriesOnly()
    {
        $path = __DIR__ . '/Asset/WithExclude';
        $excludeDirectories = [
            'Exclude',
        ];

        $this->assertClassesSatisfy(
            function (\ReflectionClass $reflection) {
                $classNames = [
                    Asset\WithExclude\ExcludeNot\Bar::class,
                    Asset\WithExclude\Exclude::class,
                ];

                $name = $reflection->getName();

                return \in_array(
                    $name,
                    $classNames,
                    true
                );
            },
            $path,
            $excludeDirectories
        );
    }

    /**
     * @dataProvider providerAssertClassesSatisfyAcceptsCallable
     *
     * @param callable $callable
     */
    public function testAssertClassesSatisfyAcceptsCallable(callable $callable)
    {
        $this->assertClassesSatisfy(
            $callable,
            __DIR__ . '/Asset/Satisfy'
        );
    }

    /**
     * @return \Generator
     */
    public function providerAssertClassesSatisfyAcceptsCallable()
    {
        return $this->provideData([
            'function' => __NAMESPACE__ . '\satisfy',
            'anonymous-function' => function (\ReflectionClass $reflection) {
                return satisfy($reflection);
            },
            'static-function' => [
                self::class,
                'satisfy',
            ],
            'instance-function' => [
                $this,
                'satisfy',
            ],
        ]);
    }

    /**
     * @param \ReflectionClass $reflection
     *
     * @return bool
     */
    public static function satisfy(\ReflectionClass $reflection)
    {
        return satisfy($reflection);
    }

    public function testAssertClassesSatisfyAcceptsMessage()
    {
        $message = 'We do not like these classes.';

        $classNames = [
            Asset\Message\Foo::class,
        ];

        $this->expectException(\PHPUnit_Framework_AssertionFailedError::class);
        $this->expectExceptionMessage($message . PHP_EOL . ' - ' . \implode(PHP_EOL . ' - ', $classNames));

        $this->assertClassesSatisfy(
            function () {
                return false;
            },
            __DIR__ . '/Asset/Message',
            [],
            $message
        );
    }

    /**
     * @param array                   $values
     * @param \Generator|\Traversable $generator
     */
    private function assertGeneratorYieldsValues(array $values, \Generator $generator)
    {
        $this->assertInstanceOf(\Traversable::class, $generator);

        $expected = \array_map(function ($value) {
            return [
                $value,
            ];
        }, $values);

        $this->assertSame($expected, \iterator_to_array($generator));
    }
}
