<?php

namespace Refinery29\Test\Util\Test\PHPUnit;

use PHPUnit_Framework_TestCase;
use Refinery29\Test\Util\PHPUnit\BuildsMockTrait;

class BuildsMockTraitTest extends PHPUnit_Framework_TestCase
{
    use BuildsMockTrait;

    public function testCanBuildMock()
    {
        $mock = $this->buildMock('Refinery29\Test\Util\Faker\Provider\Color');

        $this->assertInstanceOf('Refinery29\Test\Util\Faker\Provider\Color', $mock);
    }
}
