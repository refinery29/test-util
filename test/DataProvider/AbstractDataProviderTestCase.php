<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\DataProviderInterface;
use Refinery29\Test\Util\TestHelper;

abstract class AbstractDataProviderTestCase extends \PHPUnit_Framework_TestCase
{
    use TestHelper;

    /**
     * @return string
     */
    abstract protected function className();

    final public function testImplementsDataProviderInterface()
    {
        $reflection = new \ReflectionClass($this->className());

        $this->assertTrue($reflection->implementsInterface(DataProviderInterface::class));
    }
}
