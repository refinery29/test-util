<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

use Refinery29\Test\Util\DataProvider\Elements;
use Refinery29\Test\Util\Faker\GeneratorTrait;

class ElementsTest extends AbstractDataProviderTestCase
{
    use GeneratorTrait;

    protected function className()
    {
        return Elements::class;
    }

    public function testConstructorSetsValues()
    {
        $values = $this->getFaker()->words();

        $dataProvider = new Elements($values);

        $this->assertSame($values, $dataProvider->values());
    }
}
