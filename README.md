# test-util

[![Build Status](https://travis-ci.org/refinery29/test-util.svg?branch=master)](https://travis-ci.org/refinery29/test-util)
[![Code Climate](https://codeclimate.com/github/refinery29/test-util/badges/gpa.svg)](https://codeclimate.com/github/refinery29/test-util)
[![Test Coverage](https://codeclimate.com/github/refinery29/test-util/badges/coverage.svg)](https://codeclimate.com/github/refinery29/test-util/coverage)

Provides test helpers.

## Installation

Run:

```
$ composer require refinery29/test-util
```

## Usage

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

### PHPUnit BuildsMockTrait

If you need to easily build mocks in your tests, the `BuildsMockTrait` can be used to generate a mock, given a class name.
(see [`phpunit/phpunit`](https://github.com/sebastianbergmann/phpunit)):

```php
namespace Foo\Bar\Test;

use Jedi;
use Refinery29\Test\Util\PHPUnit\BuildsMockTrait;

class BazTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMockTrait;

    public function testNeedsMock()
    {
        $mockForce = $this->getMock('Jedi\Force');
        
        $luke = new Jedi\Luke($mockForce);

        $this->assertTrue($luke->hasTheForce());
    }
}
```

## Contributing

Please have a look at [CONTRIBUTING.md](.github/CONTRIBUTING.md).

## License

This package is licensed using the MIT License.
