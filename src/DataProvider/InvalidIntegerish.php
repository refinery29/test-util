<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidIntegerish extends AbstractDataProvider
{
    public function values()
    {
        return [
            'array' => $this->arrayOfStrings(),
            'boolean-false' => false,
            'boolean-true' => true,
            'float-negative' => $this->floatNegative(),
            'float-negative-casted-to-string' => (string) $this->floatNegative(),
            'float-positive' => $this->floatPositive(),
            'float-positive-casted-to-string' => (string) $this->floatPositive(),
            'null' => null,
            'object' => new \stdClass(),
            'resource' => $this->resource(),
            'string' => $this->string(),
        ];
    }
}
