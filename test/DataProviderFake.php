<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\Test;

use Refinery29\Test\Util\DataProvider\DataProviderInterface;

final class DataProviderFake implements DataProviderInterface
{
    private $values;

    public function __construct($values)
    {
        $this->values = $values;
    }

    public function values()
    {
        return $this->values;
    }
}
