<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

/**
 * @link http://php.net/manual/en/language.types.boolean.php#language.types.boolean.casting
 */
class Truthy extends AbstractDataProvider
{
    public function values()
    {
        return [
            'array-not-empty' => $this->arrayOfStrings(),
            'boolean-true' => true,
            'float-negative' => $this->floatNegative(),
            'float-positive' => $this->floatPositive(),
            'integer-negative' => $this->intNegative(),
            'integer-positive' => $this->intPositive(),
            'object' => new \stdClass(),
            'string-not-empty' => $this->string(),
        ];
    }
}
