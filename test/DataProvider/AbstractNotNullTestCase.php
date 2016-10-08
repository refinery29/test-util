<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test\DataProvider;

abstract class AbstractNotNullTestCase extends AbstractTestCase
{
    final public function testDoesNotProvideNull()
    {
        $reflection = new \ReflectionClass($this->className());

        $dataProvider = $reflection->newInstance();

        $this->assertNotContains(null, $dataProvider->data());
    }
}
