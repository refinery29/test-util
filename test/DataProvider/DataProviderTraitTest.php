<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\DataProviderTrait;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class DataProviderTraitTest extends \PHPUnit_Framework_TestCase
{
    use DataProviderTrait;
    use GeneratorTrait;

    public function testProvideDataYieldsValues()
    {
        $values = $this->getFaker()->words;

        $data = $this->provideData($values);

        $this->assertInstanceOf(\Traversable::class, $data);

        $expected = array_map(function ($value) {
            return [
                $value,
            ];
        }, $values);

        $this->assertSame($expected, iterator_to_array($data));
    }
}
