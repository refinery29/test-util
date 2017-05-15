<?php

/*
 * Copyright (c) 2016 Refinery29, Inc.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Refinery29\Test\Util\DataProvider;

/**
 * @link http://php.net/manual/en/function.empty.php
 */
class EmptyValue extends AbstractDataProvider
{
    public function values()
    {
        return [
            'array-empty' => [],
            'boolean-false' => [],
            'float-zero' => 0.0,
            'integer-zero' => 0,
            'null' => null,
            'string-empty' => '',
            'string-zero' => '0',
        ];
    }
}
