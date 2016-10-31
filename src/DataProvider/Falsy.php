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
class Falsy extends AbstractDataProvider
{
    public function values()
    {
        return [
            'boolean-false' => false,
            'empty-string' => '',
            'string-containing-zero' => '0',
            'empty-array' => [],
            'float-zero' => 0.0,
            'integer-zero' => 0,
            'null' => null,
        ];
    }
}
