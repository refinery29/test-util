<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidBoolean extends AbstractDataProvider
{
    public function values()
    {
        return [
            'array' => $this->arrayOfStrings(),
            'float-negative' => $this->floatNegative(),
            'float-positive' => $this->floatPositive(),
            'float-zero' => 0.0,
            'integer-negative' => $this->intNegative(),
            'integer-positive' => $this->intPositive(),
            'integer-zero' => 0,
            'null' => null,
            'object' => new \stdClass(),
            'resource' => $this->resource(),
            'string' => $this->string(),
        ];
    }
}
