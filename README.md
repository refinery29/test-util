# test-util

[![Build Status](https://travis-ci.org/refinery29/test-util.svg?branch=master)](https://travis-ci.org/refinery29/test-util)
[![Code Climate](https://codeclimate.com/github/refinery29/test-util/badges/gpa.svg)](https://codeclimate.com/github/refinery29/test-util)
[![Test Coverage](https://codeclimate.com/github/refinery29/test-util/badges/coverage.svg)](https://codeclimate.com/github/refinery29/test-util/coverage)

Provides test helpers and generic data providers.

## Installation

Run:

```
$ composer require refinery29/test-util
```

## Usage

### Data Provider

If you need to assert that invalid values are rejected, you can use one 
of the data providers:

* `Refinery29\Test\Util\DataProvider\BlankString`
* `Refinery29\Test\Util\DataProvider\InvalidBoolean`
* `Refinery29\Test\Util\DataProvider\InvalidBooleanNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidFloat`
* `Refinery29\Test\Util\DataProvider\InvalidFloatNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidInteger`
* `Refinery29\Test\Util\DataProvider\InvalidIntegerNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidIntegerNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidNumeric`
* `Refinery29\Test\Util\DataProvider\InvalidNumericNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidScalar`
* `Refinery29\Test\Util\DataProvider\InvalidScalarNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidString`
* `Refinery29\Test\Util\DataProvider\InvalidStringNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidUrl`
* `Refinery29\Test\Util\DataProvider\InvalidUrlNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidUuid`
* `Refinery29\Test\Util\DataProvider\InvalidUuidNotNull`

If you need generic values, you can use one of the data providers

* `Refinery29\Test\Util\DataProvider\Boolean`

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;

class BazTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider Refinery29\Test\Util\DataProvider\InvalidString::data()
     * 
     * @param mixed $name
     */
    public function testConstructorRejectsInvalidValue($name)
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Baz($name);
    }
}
```

### Faker GeneratorTrait

If you need fake data in your tests, the `GeneratorTrait` comes in very handy, as it
yields an instance of `Faker\Generator` (see [`fzaninotto/faker`](https://github.com/fzaninotto/Faker)):

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class BazTest extends \PHPUnit_Framework_TestCase
{
    use GeneratorTrait;

    public function testConstructorSetsName()
    {
        $faker = $this->getFaker();

        $name = $faker->name;
        $date = $faker->dateTime;

        $baz = new Baz(
            $name,
            $date
        );

        $this->assertSame($name, $baz->name());
        $this->assertNotSame($dateTime, $baz->date());
        $this->assertEquals($dateTime, $baz->date());
    }
}
```

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CONDUCT.md`](.github/CONDUCT.md).

## License

This package is licensed using the MIT License.
