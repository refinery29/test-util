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
* `Refinery29\Test\Util\DataProvider\InvalidIntegerish`
* `Refinery29\Test\Util\DataProvider\InvalidIntegerishNotNull`
* `Refinery29\Test\Util\DataProvider\InvalidIsoDate`
* `Refinery29\Test\Util\DataProvider\InvalidIsoDateNotNull`
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
* `Refinery29\Test\Util\DataProvider\Scalar`

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;

class BazTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidString::data()
     * 
     * @param mixed $name
     */
    public function testConstructorRejectsInvalidValue($name)
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Baz($name);
    }
}
```

### Helpers

If you want to make use of a few test helpers, use the `Refinery29\Test\Util\TestHelper` trait!

#### Providing data from an array of values

Use `provideData()` to provide values from an array of values:

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;
use Refinery29\Test\Util\TestHelper;

class BazTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;
    
    /**
     * @dataProvider providerInvalidValue
     * 
     * @param mixed $name
     */
    public function testConstructorRejectsInvalidValue($name)
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Baz($name);
    }
    
    /**
     * @return \Generator
     */
    public function providerInvalidValue()
    {
        return $this->provideData([
            'foo',
            'bar',
        ]);
    }
}
```

#### Providing data from multiple concrete data providers

Use `provideDataFrom()` to provide values from multiple concrete data providers:

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;
use Refinery29\Test\Util\DataProvider;
use Refinery29\Test\Util\TestHelper;

class BazTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;
    
    /**
     * @dataProvider providerInvalidValue
     * 
     * @param mixed $name
     */
    public function testConstructorRejectsInvalidValue($name)
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Baz($name);
    }
    
    /**
     * @return \Generator
     */
    public function providerInvalidValue()
    {
        return $this->provideDataFrom(
            new DataProvider\InvalidString(),
            new DataProvider\BlankString()
        );
    }
}
```

#### Providing data from concrete data providers and arrays of data

Use `provideDataFrom()` along with the `Elements` data provider to 
combine concrete data providers with data from an array of values:

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;
use Refinery29\Test\Util\DataProvider;
use Refinery29\Test\Util\TestHelper;

class BazTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;
    
    /**
     * @dataProvider providerInvalidValue
     * 
     * @param mixed $name
     */
    public function testConstructorRejectsInvalidValue($name)
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Baz($name);
    }
    
    /**
     * @return \Generator
     */
    public function providerInvalidValue()
    {
        return $this->provideDataFrom(
            new DataProvider\InvalidString(),
            new DataProvider\BlankString(),
            new DataProvider\Elements([
                'foo',
                'bar',
            ])
        );
    }
}
```

### Faker

If you need fake data in your tests, lazily fetch an instance of `Faker\Generator` 
(see [`fzaninotto/faker`](https://github.com/fzaninotto/Faker)) using `getFaker()`

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;
use Refinery29\Test\Util\TestHelper;

class BazTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

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
        $this->assertNotSame($date, $baz->date());
        $this->assertEquals($date, $baz->date());
    }
}
```

If you need an instance of `Faker\Generator` with a locale other than 
the default (`en_US`), pass in the locale to `getFaker()`:

```php
namespace Foo\Bar\Test;

use Foo\Bar\Baz;
use Refinery29\Test\Util\TestHelper;

class BazTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    public function testConstructorSetsName()
    {
        $faker = $this->getFaker('de_DE');

        $name = $faker->name;
        $date = $faker->dateTime;

        $baz = new Baz(
            $name,
            $date
        );

        $this->assertSame($name, $baz->name());
        $this->assertNotSame($date, $baz->date());
        $this->assertEquals($date, $baz->date());
    }
}
```

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CONDUCT.md`](.github/CONDUCT.md).

## License

This package is licensed using the MIT License.
