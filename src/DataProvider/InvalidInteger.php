<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidInteger extends AbstractDataProvider
{
    public function values()
    {
        return [
            'array' => $this->arrayOfStrings(),
            'boolean-false' => false,
            'boolean-true' => true,
            'float-negative' => $this->floatNegative(),
            'float-positive' => $this->floatPositive(),
            'float-zero' => 0.0,
            'integer-negative-casted-to-string' => (string) $this->intNegative(),
            'integer-positive-casted-to-string' => (string) $this->intPositive(),
            'integer-zero-casted-to-string' => (string) 0,
            'null' => null,
            'object' => new \stdClass(),
            'resource' => $this->resource(),
            'string' => $this->string(),
        ];
    }
}
