<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test;

use PHPUnit\Framework;
use Refinery29\Test\Util\TestHelper;

final class TestClassTest extends Framework\TestCase
{
    use TestHelper;

    public function testTestClassesAreAbstractOrFinal()
    {
        $this->assertClassesAreAbstractOrFinal(__DIR__, [
            'Asset',
        ]);
    }
}
