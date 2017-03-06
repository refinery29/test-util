# test-util

[![Build Status](https://travis-ci.org/refinery29/test-util.svg?branch=master)](https://travis-ci.org/refinery29/test-util)
[![Code Climate](https://codeclimate.com/github/refinery29/test-util/badges/gpa.svg)](https://codeclimate.com/github/refinery29/test-util)
[![Test Coverage](https://codeclimate.com/github/refinery29/test-util/badges/coverage.svg)](https://codeclimate.com/github/refinery29/test-util/coverage)
[![Issue Count](https://codeclimate.com/github/refinery29/test-util/badges/issue_count.svg)](https://codeclimate.com/github/refinery29/test-util)
[![Latest Stable Version](https://poser.pugx.org/refinery29/test-util/v/stable)](https://packagist.org/packages/refinery29/test-util)
[![Total Downloads](https://poser.pugx.org/refinery29/test-util/downloads)](https://packagist.org/packages/refinery29/test-util)

Provides a test helper, generic data providers, and assertions.

## Installation

Run:

```
$ composer require refinery29/test-util
```

## Usage

### Test Helper

If you want to make use of the test helper, import the `Refinery29\Test\Util\TestHelper` trait!

```php
namespace Acme\Test;

use Refinery29\Test\Util\TestHelper;

final class WebsiteTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;
}
```

#### Additional Assertions

The test helper provides a few assertions:

* `assertClassesAreAbstractOrFinal($path, array $excludeDirectories = [])`
* `assertClassesSatisfy(callable $specification, $path, array $excludeDirectories = [])`
* `assertFinal($className)`
* `assertExtends($parentClassName, $className)`
* `assertImplements($interfaceName, $className)`

##### `assertClassesSatisfy(callable $specification, $path, array $excludeDirectories = [])`

The callable will be passed in an instance of `ReflectionClass` which can
be used for further introspection, and should return a `bool`, indicating
that the specification is satisfied.

For example:

```php
$this->assertClassesSatisfy(
    function (\ReflectionClass $reflection) {
        return false !== \strpos('MySmallClass', $reflection->getName());
    },
    __DIR__
);
```

#### Generating fake data using Faker

Lazily fetch an instance of `Faker\Generator` (see [`fzaninotto/faker`](https://github.com/fzaninotto/Faker)) using

* `getFaker($locale = 'en_US') : \Faker\Generator`

#### Providing data from an array of values

Quickly provide data from an array of values, using

* `provideData(array $data) : \Generator`

#### Providing data from multiple concrete data providers

Quickly provide data from multiple concrete data providers using

* `provideDataFrom(...$dataProviders) : \Generator`

### Data Providers

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
* `Refinery29\Test\Util\DataProvider\Falsy`
* `Refinery29\Test\Util\DataProvider\Scalar`
* `Refinery29\Test\Util\DataProvider\Truthy`

If you want to mix data providers above with some arbitrary values, use

* `Refinery29\Test\Util\DataProvider\Elements`

### Example

Putting it all together, here's an example of a test making use of the test helper:

```php
namespace Acme\Test;

use Acme\Website;
use Refinery29\Test\Util\DataProvider;
use Refinery29\Test\Util\TestHelper;

final class WebsiteTest extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    /**
     * @dataProvider providerInvalidTitle
     * 
     * @param mixed $title
     */
    public function testConstructorRejectsInvalidTitle($title)
    {
        $this->expectException(\InvalidArgumentException::class);
        
        new Website($title);
    }
    
    /**
     * @return \Generator
     */
    public function providerInvalidTitle()
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
    
    public function testConstructorSetsTitle()
    {
        $title = $this->getFaker()->sentence();
        
        $website = new Website($title);
        
        $this->assertSame($title, $website->title());
    }
    
    /**
     * @dataProvider \Refinery29\Test\Util\DataProvider\InvalidUrl::data()
     * 
     * @param mixed $url
     */
    public function testWithUrlRejectsInvalidUrl($url)
    {
        $title = $this->getFaker()->sentence();
        
        $website = new Website($title);
        
        $this->expectException(\InvalidArgumentException::class);
        
        $website->withUrl($url);
    }
    
    /**
     * @dataProvider providerUrl
     * 
     * @param string $url
     */
    public function testWithUrlClonesInstanceAndSetsUrl($url)
    {
        $title = $this->getFaker()->sentence();
        
        $website = new Website($title);
        
        $mutated = $website->withUrl($url);
        
        $this->assertInstanceOf(Website::class, $mutated);
        $this->assertNotSame($website, $mutated);
        $this->assertSame($url, $mutated->url());
    }
 
    /**
     * @return \Generator
     */
    public function providerUrl()
    {
        return $this->provideData([
            'http://www.refinery29.com',
            'http://www.refinery29.de',
            'http://www.refinery29.uk',
        ]);
    }
}
```

## Contributing

Please have a look at [`CONTRIBUTING.md`](.github/CONTRIBUTING.md).

## Code of Conduct

Please have a look at [`CONDUCT.md`](.github/CONDUCT.md).

## License

This package is licensed using the MIT License.
