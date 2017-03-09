<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

class InvalidString extends AbstractDataProvider
{
    public function values()
    {
        return [
            'array' => $this->arrayOfStrings(),
            'boolean-false' => false,
            'boolean-true' => true,
            'float' => $this->floatPositive(),
            'integer' => $this->intPositive(),
            'null' => null,
            'resource' => $this->resource(),
            'object' => new \stdClass(),
        ];
    }
}
